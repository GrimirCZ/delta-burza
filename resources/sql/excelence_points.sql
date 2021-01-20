-- ==============================================================
-- FUNCTION excelence_point()
-- ==============================================================
DROP FUNCTION IF EXISTS excelence_point;
DELIMITER //
CREATE FUNCTION excelence_point(contest_results_id bigint, vyear int, vcontest_level_id bigint, vregion varchar(255), vplace int, vsurname varchar(255), vcontest_id bigint, vschool_id bigint) RETURNS decimal(3,2)

begin

declare excelence_point decimal(3,2);
declare vpocet int;
declare vexcelence_level_id bigint;
declare vcoeficient decimal(3,2);

-- ------------------------------------------------
-- lokální proměnná pro umístění v celostátním kole
-- ------------------------------------------------
declare lplace int; 
declare lpocet int;

-- ------------------------------------------------
-- ověření zda je soutěž vůbec zařazena v excelenci
-- ------------------------------------------------
SELECT count(*), excelence_level_id, excelence_levels.coeficient into vpocet, vexcelence_level_id, vcoeficient FROM contest_excelence, excelence_levels
WHERE contest_excelence.contest_id=vcontest_id
  AND contest_excelence.year=vyear
  AND contest_excelence.excelence_level_id=excelence_levels.id
GROUP BY 2,3;

if vpocet>0 then
-- je v excelenci  
	case 
	  when vexcelence_level_id=3 or vexcelence_level_id=4 or vexcelence_level_id=5 then
	  -- body do 3. místa v celostátním kole
		if vplace<=3 AND vcontest_level_id=2 then set excelence_point=1;
		else set excelence_point=0;
		end if;
	  when vexcelence_level_id=6 then
	  -- body do 3. místa v krajském kole, celostátní kolo není
		if vplace<=3 AND vcontest_level_id=1 then set excelence_point=1;
		else set excelence_point=0;
		end if;
	  when vexcelence_level_id=1 or vexcelence_level_id=2 or vexcelence_level_id=7 then 
	  -- top soutěže (krajské kolo do 6. místa, celostátní první 1/3)
		if vcontest_level_id=1 then
		-- krajské kolo
			if vplace<=6 then
				-- zjištění, zda nebyl poslední
				SELECT max(place) INTO vpocet FROM contest_results
				WHERE contest_results.contest_id=vcontest_id
				  AND contest_results.year=vyear
				  AND contest_results.contest_level_id=vcontest_level_id
				  AND contest_results.region=vregion
				  AND contest_results.place>vplace;
				if vpocet>0 then set excelence_point=1;
				else
				-- byl do 6. místa, ale poslední. Zjišťuje se, zda postoupil do celostátního kola.
					SELECT place INTO lplace FROM contest_results
					WHERE contest_results.contest_id=vcontest_id
					  AND contest_results.year=vyear
					  AND contest_results.contest_level_id=2
					  AND contest_results.school_id=vschool_id
					  AND contest_results.surname=vsurname;
				        if lplace IS NOT NULL then
					-- jestliže postoupil do celostátního kola, zjišťuje se, zda v něm neskončil v posledních 10%.
							SELECT max(place) INTO lpocet FROM contest_results
							WHERE contest_results.contest_id=vcontest_id
							  AND contest_results.year=vyear
							  AND contest_results.contest_level_id=2
							  AND contest_results.place>lplace;
							if 1-lplace/(lplace+lpocet)>0.1 then set excelence_point=1;
							else set excelence_point=0;
							end if;
					else set excelence_point=0;
				    	end if; 
				end if;
			else set excelence_point=0;
			end if;
		elseif vcontest_level_id=2 then 
		-- celostátní kolo
			if vplace<=3 then set excelence_point=2;
			else
				SELECT max(place) INTO lpocet FROM contest_results
				WHERE contest_results.contest_id=vcontest_id
			  	  AND contest_results.year=vyear
			  	  AND contest_results.contest_level_id=2;
				
				if vplace/lpocet<=0.34 AND vplace<=10 then set excelence_point=1;
				-- jestliže byl v celorepublikovém kole v 1/3 a zároveň do 10. místa, tak dostane 1 bod
				else set excelence_point=0;
		                end if;
			end if;
		elseif vcontest_level_id=3 then set excelence_point=1;
		-- mezinárodní kolo - účast 1 bod
		end if;
	  else set excelence_point=0;
	  -- nepadá do žádné kategorie excelence
	end case;
else
  set excelence_point=0;
  -- nepadá do žádné kategorie excelence
end if;

set excelence_point=excelence_point*vcoeficient;
-- násobení koeficientem dle zařazení soutěže do kategorie excelence

-- počet ve družstvu
if excelence_point>0 then
	SELECT count(*) INTO lpocet FROM contest_results
	WHERE contest_results.contest_id=vcontest_id
	  AND contest_results.region=vregion
	  AND contest_results.year=vyear
	  AND contest_results.contest_level_id=vcontest_level_id
	  AND contest_results.place=vplace
	  AND contest_results.school_id=vschool_id;
	-- dělení bodů na jednotlivé účastníky družstva
	set excelence_point=excelence_point/lpocet;

	if lpocet>3 then
	-- jestliže jsou z jedné školy v rámci jedné soutěže v jednom levelu umístěni na stejném místě více než 3 žáci, zdvojnásobí se počet bodů
		set excelence_point=excelence_point*2;
	end if;
end if;

return excelence_point;
end//
DELIMITER ;

DROP TABLE IF EXISTS tmp_contest_results;
CREATE TABLE tmp_contest_results LIKE contest_results;
INSERT INTO tmp_contest_results
SELECT * FROM contest_results;

UPDATE tmp_contest_results SET expoint=excelence_point(id, year, contest_level_id, region, place, surname, contest_id, school_id)
WHERE id >0 AND id <=5000;
UPDATE tmp_contest_results SET expoint=excelence_point(id, year, contest_level_id, region, place, surname, contest_id, school_id)
WHERE id >5000 AND id <=10000;
UPDATE tmp_contest_results SET expoint=excelence_point(id, year, contest_level_id, region, place, surname, contest_id, school_id)
WHERE id >10000 AND id <=15000;
UPDATE tmp_contest_results SET expoint=excelence_point(id, year, contest_level_id, region, place, surname, contest_id, school_id)
WHERE id >15000 AND id <=20000;
UPDATE tmp_contest_results SET expoint=excelence_point(id, year, contest_level_id, region, place, surname, contest_id, school_id)
WHERE id >20000 AND id <=25000;
UPDATE tmp_contest_results SET expoint=excelence_point(id, year, contest_level_id, region, place, surname, contest_id, school_id)
WHERE id >25000 AND id <=30000;
UPDATE tmp_contest_results SET expoint=excelence_point(id, year, contest_level_id, region, place, surname, contest_id, school_id)
WHERE id >30000 AND id <=35000;
UPDATE tmp_contest_results SET expoint=excelence_point(id, year, contest_level_id, region, place, surname, contest_id, school_id)
WHERE id >35000 AND id <=40000;
UPDATE tmp_contest_results SET expoint=excelence_point(id, year, contest_level_id, region, place, surname, contest_id, school_id)
WHERE id >40000 AND id <=45000;
UPDATE tmp_contest_results SET expoint=excelence_point(id, year, contest_level_id, region, place, surname, contest_id, school_id)
WHERE id >45000 AND id <=50000;
UPDATE tmp_contest_results SET expoint=excelence_point(id, year, contest_level_id, region, place, surname, contest_id, school_id)
WHERE id >50000 AND id <=55000;
UPDATE tmp_contest_results SET expoint=excelence_point(id, year, contest_level_id, region, place, surname, contest_id, school_id)
WHERE id >55000 AND id <=60000;
UPDATE tmp_contest_results SET expoint=excelence_point(id, year, contest_level_id, region, place, surname, contest_id, school_id)
WHERE id >60000 AND id <=65000;
UPDATE tmp_contest_results SET expoint=excelence_point(id, year, contest_level_id, region, place, surname, contest_id, school_id)
WHERE id >65000 AND id <=70000;
UPDATE tmp_contest_results SET expoint=excelence_point(id, year, contest_level_id, region, place, surname, contest_id, school_id)
WHERE id >70000 AND id <=75000;
UPDATE tmp_contest_results SET expoint=excelence_point(id, year, contest_level_id, region, place, surname, contest_id, school_id)
WHERE id >75000 AND id <=80000;

UPDATE contest_results SET expoint= (SELECT expoint FROM tmp_contest_results WHERE tmp_contest_results.id=contest_results.id);
DROP TABLE tmp_contest_results;
