DROP TABLE IF EXISTS contest_excelence;
DROP TABLE IF EXISTS contest_results;
-- -----------------------------------------------------
-- Table `contests`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `contests` ;

CREATE TABLE IF NOT EXISTS `contests` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `excelence_levels`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `excelence_levels` ;

CREATE TABLE IF NOT EXISTS `excelence_levels` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `coeficient` DECIMAL NOT NULL,
  `description` TEXT(1000) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `contest_excelence`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `contest_excelence` ;

CREATE TABLE IF NOT EXISTS `contest_excelence` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `year` INT NOT NULL,
  `contest_id` BIGINT NOT NULL,
  `excelence_level_id` BIGINT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_contest_level_contests1_idx` (`contest_id` ASC),
  INDEX `fk_contest_level_excelence_levels1_idx` (`excelence_level_id` ASC),
  CONSTRAINT `fk_contest_level_contests1`
    FOREIGN KEY (`contest_id`)
    REFERENCES `contests` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_contest_level_excelence_levels1`
    FOREIGN KEY (`excelence_level_id`)
    REFERENCES `excelence_levels` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `contest_levels`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `contest_levels` ;

CREATE TABLE IF NOT EXISTS `contest_levels` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `contest_results`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `contest_results` ;

CREATE TABLE IF NOT EXISTS `contest_results` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `year` INT NOT NULL,
  `contest_level_id` BIGINT NOT NULL,
  `region` VARCHAR(255) NULL,
  `place` INT NOT NULL,
  `name` VARCHAR(255) NULL,
  `surname` VARCHAR(255) NULL,
  `contest_id` BIGINT NOT NULL,
  `school_id` BIGINT NOT NULL,
  `expoint` DECIMAL NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_contest_results_contest_levels1_idx` (`contest_level_id` ASC),
  INDEX `fk_contest_results_contests1_idx` (`contest_id` ASC),
  INDEX `fk_contest_results_schools1_idx` (`school_id` ASC),
  CONSTRAINT `fk_contest_results_contest_levels1`
    FOREIGN KEY (`contest_level_id`)
    REFERENCES `contest_levels` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_contest_results_contests1`
    FOREIGN KEY (`contest_id`)
    REFERENCES `contests` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -------------------------------------------------
-- contests
-- -------------------------------------------------
INSERT INTO contests (name) SELECT DISTINCT name FROM tmp_contest_instances ORDER BY name;

-- -------------------------------------------------
-- excelence_levels
-- -------------------------------------------------
INSERT INTO excelence_levels (name, coeficient, description) VALUES
('skupina 1',1,'prvních 6 kraj, třetina celostátní'),
('skupina 2',0.5,'prvních 6 kraj, třetina celostátní'),
('skupina 3',1,'první 3 celostátní'),
('skupina 4',0.5,'první 3 celostátní'),
('skupina 5',1,'první 3 celostátní'),
('skupina 6',0.25,'první 3 kraj');

-- -------------------------------------------------
-- contest_excelence 2019
-- -------------------------------------------------
TRUNCATE TABLE contest_excelence;
INSERT INTO contest_excelence (year, contest_id, excelence_level_id)
SELECT '2019',id,1 FROM contests;

UPDATE contest_excelence SET excelence_level_id=2
WHERE contest_id IN (SELECT id FROM contests WHERE name LIKE 'soutěže v cizích%');
UPDATE contest_excelence SET excelence_level_id=2
WHERE contest_id IN (100,183,95,156, 165, 168, 161, 158);

UPDATE contest_excelence SET excelence_level_id=3
WHERE contest_id IN (73,74,50,18,19,20,21,22,23,24,25,26,27,132,39,40,65,42,113,123);

UPDATE contest_excelence SET excelence_level_id=4
WHERE contest_id IN (44,102,172,28,29,43,107);

-- ------------------
-- zjistil jsem chybu v datech
-- --------------------
DELETE FROM contest_excelence WHERE contest_id=129;
DELETE FROM contests WHERE id=129;
UPDATE tmp_contest_instances SET name='Celostátní soutěž první pomoci (SZŠ)' WHERE name='Soutěž první pomoci';

UPDATE contest_excelence SET excelence_level_id=5
WHERE contest_id IN (9,10,11,12,149,150,151,175,101,63,173,57,58,59,109,110,111,60,61);

-- ------------------
-- zjistil jsem chybu v datech
-- --------------------
DELETE FROM contest_excelence WHERE contest_id=128;
DELETE FROM contests WHERE id=128;
UPDATE tmp_contest_instances SET name='Učeň instalatér' WHERE name='Soutěž odborných dovedností Učeň instalatér';

DELETE FROM contest_excelence WHERE contest_id=93;
DELETE FROM contests WHERE id=93;
UPDATE tmp_contest_instances SET name='Pokrývač - Mistrovství ČR' WHERE name='Mistrovství České republiky odborných dovedností žáků oboru vzdělání - pokrývač';

DELETE FROM contest_excelence WHERE contest_id=92;
DELETE FROM contests WHERE id=92;
UPDATE tmp_contest_instances SET name='Klempíř - Mistrovství ČR' WHERE name='Mistrovství České republiky odborných dovedností žáků oboru vzdělání - klempíř';

DELETE FROM contest_excelence WHERE contest_id=94;
DELETE FROM contests WHERE id=94;
UPDATE tmp_contest_instances SET name='Tesař - Mistrovství ČR' WHERE name='Mistrovství České republiky odborných dovedností žáků oboru vzdělání - tesař';

UPDATE contest_excelence SET excelence_level_id=6
WHERE contest_id IN (4,5,49,47,48,13,14,176,177);

DELETE FROM contest_excelence WHERE excelence_level_id=1 AND contest_id NOT IN
(69,70,71,72,86,51,52,53,54,82,90,174,2,3,79,15,16,80,36,37,38,81,130,131,154,155,156,157,158,159,160,161,162,163,164,165,166,167,168,169,170,171);

-- -------------------------------------------------
-- contest_excelence 2018
-- -------------------------------------------------
INSERT INTO contest_excelence (year, contest_id, excelence_level_id)
SELECT 2018, contest_id, excelence_level_id FROM contest_excelence WHERE year=2019;

DELETE FROM contest_excelence WHERE year=2018 AND
contest_id IN (42,113,123);

INSERT INTO contest_excelence (year, contest_id, excelence_level_id) VALUES
(2018,17,4),
(2018,41,4),
(2018,97,4);

DELETE FROM contest_excelence WHERE year=2018 AND
contest_id IN (60,61);
INSERT INTO contest_excelence (year, contest_id, excelence_level_id) VALUES
(2018,96,5);
DELETE FROM contest_excelence WHERE year=2018 AND
excelence_level_id=6;
-- -------------------------------------------------
-- contest_excelence 2017
-- -------------------------------------------------
INSERT INTO contest_excelence (year, contest_id, excelence_level_id)
SELECT 2017, contest_id, excelence_level_id FROM contest_excelence WHERE year=2018;

DELETE FROM contest_excelence WHERE year=2017 AND
contest_id=40;

INSERT INTO contest_excelence (year, contest_id, excelence_level_id) VALUES
(2017,75,3),
(2017,76,3),
(2017,104,3),
(2017,62,3);

UPDATE contest_excelence SET excelence_level_id= 3 WHERE year=2017 AND
contest_id IN (9,10,11,12,149,150,151,175,63,101,173,57,58,59,109,110,111);

DELETE FROM contest_excelence WHERE year=2017 AND
contest_id=97;

INSERT INTO contest_excelence (year, contest_id, excelence_level_id) VALUES
(2017,46,4),
(2017,45,4),
(2017,105,4),
(2017,96,4);

DELETE FROM contest_excelence WHERE year=2017 AND
excelence_level_id=5;

-- -------------------------------------------------
-- contest_excelence 2016
-- -------------------------------------------------
INSERT INTO contest_excelence (year, contest_id, excelence_level_id)
SELECT 2016, contest_id, excelence_level_id FROM contest_excelence WHERE year=2017;

-- -------------------------------------------------
-- contest_excelence 2015
-- -------------------------------------------------
INSERT INTO contest_excelence (year, contest_id, excelence_level_id)
SELECT 2015, contest_id, excelence_level_id FROM contest_excelence WHERE year=2016;

INSERT INTO contest_excelence (year, contest_id, excelence_level_id) VALUES
(2015,99,3);

DELETE FROM contest_excelence WHERE year=2015 AND
contest_id IN (57,58,59,109,110,111,65,62);

DELETE FROM contest_excelence WHERE year=2015 AND
contest_id IN (17);

INSERT INTO contest_excelence (year, contest_id, excelence_level_id) VALUES
(2015,115,4),
(2015,125,4),
(2015,126,4),
(2015,119,4);

INSERT INTO excelence_levels (name, coeficient, description) VALUES
('skupina 7',0.2,'prvních 6 kraj, třetina celostátní');

UPDATE contest_excelence SET excelence_level_id=7 WHERE year=2015 and excelence_level_id=2;

-- --------------------------------------------------------------------
-- contest_levels
-- --------------------------------------------------------------------
INSERT INTO contest_levels(name) VALUES
('krajské kolo'),
('ústřední kolo'),
('mezinárodní kolo');

-- --------------------------------------------------------------------
-- oprava IČO škol
-- --------------------------------------------------------------------
UPDATE tmp_contest_participants SET ico='06668356' WHERE ico='13584898';
UPDATE tmp_contest_participants SET ico='06668356' WHERE ico='14450356';
UPDATE tmp_contest_participants SET ico='14450453' WHERE ico='48623725';
UPDATE tmp_contest_participants SET ico='06668224' WHERE ico='15046249';
UPDATE tmp_contest_participants SET ico='06668151' WHERE ico='15055663';
UPDATE tmp_contest_participants SET ico='48109355' WHERE ico='27572498';
UPDATE tmp_contest_participants SET ico='06668275' WHERE ico='48623661';
UPDATE tmp_contest_participants SET ico='06668275' WHERE ico='48623717';
UPDATE tmp_contest_participants SET ico='49767194' WHERE ico='49767208';
UPDATE tmp_contest_participants SET ico='06668224' WHERE ico='529681';
UPDATE tmp_contest_participants SET ico='00843105' WHERE ico='60045035';
UPDATE tmp_contest_participants SET ico='06668364' WHERE ico='60116927';
UPDATE tmp_contest_participants SET ico='60153245' WHERE ico='60153326';
UPDATE tmp_contest_participants SET ico='13582968' WHERE ico='60153334';
UPDATE tmp_contest_participants SET ico='63289938' WHERE ico='60650818';
UPDATE tmp_contest_participants SET ico='62033026' WHERE ico='62033077';
UPDATE tmp_contest_participants SET ico='25272501' WHERE ico='62063243';
UPDATE tmp_contest_participants SET ico='03620280' WHERE ico='62540076';
UPDATE tmp_contest_participants SET ico='62690221' WHERE ico='62690159';
UPDATE tmp_contest_participants SET ico='00846279' WHERE ico='63731371';
UPDATE tmp_contest_participants SET ico='04235380' WHERE ico='63998181';
UPDATE tmp_contest_participants SET ico='06668356' WHERE ico='653705';
UPDATE tmp_contest_participants SET ico='48623725' WHERE ico='14450453';
UPDATE tmp_contest_participants SET ico='25348931' WHERE ico='25341863';

-- --------------------------------------------------------------------
-- Chybí nám
-- --------------------------------------------------------------------
-- konzervatoře
-- 49778111 Konzervatoř Kopeckého sady 328 Plzeň PSČ: 30100
-- 60075902 Konzervatoř Kanovnická 22 České Budějovice PSČ: 37061
-- 602078   Janáčkova konzervatoř v Ostravě Českobratrská 958 Ostrava PSČ: 70200
-- 61515779 Konzervatoř Českobratrská 15 Teplice PSČ: 41501
-- 62157213 Konzervatoř Brno, příspěvková organizace tř. Kpt. Jaroše 45 Brno PSČ: 66254
-- 70837911 Pražská konzervatoř Na Rejdišti 1 Praha 1 PSČ: 11000
-- 70844534 Konzervatoř  P.  J. Vejvanovského Pilařova 7 Kroměříž PSČ: 76701
-- 838144   Konzervatoř Evangelické akademie Wurmova 13 Olomouc PSČ: 77900

-- 25326384 Manažerská akademie - SOŠ, s.r.o. Jiráskova 2 Jihlava PSČ: 58601
-- 25335022 Soukromá VOŠ a SUŠ grafická, s.r.o. Křížová 18 Jihlava PSČ: 58601
-- 25571338 Soukromé gymnázium AD FONTES, o.p.s. Fibichova 18 Jihlava PSČ: 58601
-- 380661 SOŠ sociální u Matky Boží Jihlava Fibichova 978 Jihlava PSČ: 58601
-- 48895377 HŠ Světlá a SOŠŘ Velké Meziříčí U Světlé 855 Velké Meziříčí PSČ: 59401
-- 48895393 Gymnázium Velké Meziříčí Sokolovská 235/27 Velké Meziříčí PSČ: 59401
-- 48895407 Gymnázium Žďár nad Sázavou Neumannova 2 Žďár nad Sázavou PSČ: 59101
-- 60418427 Gymnázium a SOŠ Tyršova 365 Moravské Budějovice PSČ: 67619
-- 60418435 Gymnázium Třebíč Masarykovo nám. 116/9 Třebíč PSČ: 67401
-- 60418460 VOŠ a SŠ veter., zeměd. a zdrav. Třebíč Žižkova 505 Třebíč PSČ: 67423
-- 60545976 Střední uměleckoprůmyslová škola Hálkova 42 Jihlava - Helenín PSČ: 58603
-- 60545984 Gymnázium Jihlava Jana Masaryka 1 Jihlava PSČ: 58601
-- 60545992 SŠ průmyslová, technická a automobilní tř. Legionářů 3 Jihlava PSČ: 58601
-- 62540041 Gymnázium dr. A. Hrdličky Komenského 147 Humpolec PSČ: 39601
-- 03620280 Gymnázium Pacov Hronova 1079 Pacov PSČ: 39501
-- 637696 SZŠ a VOŠZ Žďár nad Sázavou Dvořákova 4 Žďár nad Sázavou PSČ: 59101
-- 66610699 OA Dr. A. Bráfa, Hotel. šk. a Jazyk. šk. Sirotčí 4 Třebíč PSČ: 67401
-- 66610702 Střední průmyslová škola Třebíč Manželů Curieových 734 Třebíč PSČ: 67401
-- 67009425 Střední odborná škola Bělisko 295 Nové Město na Moravě PSČ: 59231
-- --------------------------------------------------------------------
-- contest_results
-- --------------------------------------------------------------------
INSERT INTO contest_results(year, contest_level_id, region, place, name, surname, contest_id, school_id, expoint)
SELECT tmp_contest_instances.year,contest_levels.id, tmp_contest_instances.district,tmp_contest_participants.place, tmp_contest_participants.name, tmp_contest_participants.surname, contests.id, schools.id,0
FROM tmp_contest_participants, tmp_contest_instances, contest_levels, contests, schools
WHERE tmp_contest_participants.contest_id=tmp_contest_instances.id
  AND tmp_contest_instances.name=contests.name
  AND tmp_contest_participants.ico*1=schools.ico*1
  AND tmp_contest_instances.level=contest_levels.name;



-- CONFIGG DB
-- ALTER DATABASE burza_dev
-- DEFAULT CHARACTER SET = utf8
-- DEFAULT COLLATE=utf8_general_ci;
-- SET NAMES UTF8;

-- ==============================================================
-- FUNCTION excelence_point()
-- ==============================================================
DROP FUNCTION IF EXISTS excelence_point;
DELIMITER //
CREATE FUNCTION excelence_point(vschool_id bigint, vyear int, vcontest_id bigint, vcontest_level_id bigint, vregion varchar(255), vplace int) RETURNS decimal(3,2)

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
				SELECT count(*) INTO vpocet FROM contest_results
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
					  AND contest_results.name IN (SELECT name FROM contest_results
								       WHERE contest_results.school_id=vschool_id
									  AND contest_results.contest_id=vcontest_id
									  AND contest_results.year=vyear
									  AND contest_results.contest_level_id=1
									  AND contest_results.region=vregion
									  AND contest_results.place=vplace);
				        if lplace IS NOT NULL then
					-- jestliže postoupil do celostátního kola, zjišťuje se, zda v něm neskončil v posledních 10%.
							SELECT count(*) INTO lpocet FROM contest_results
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
				SELECT count(*) INTO lpocet FROM contest_results
				WHERE contest_results.contest_id=vcontest_id
			  	  AND contest_results.year=vyear
			  	  AND contest_results.contest_level_id=2;

				if vplace/lpocet<=0.33 AND vplace<=10 then set excelence_point=1;
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

	if lpocet>3 then
-- jestliže jsou z jedné školy v rámci jedné soutěže v jednom levelu umístěni na stejném místě více než 3 žáci, zdvojnásobí se počet bodů
		set excelence_point=excelence_point*2;
	end if;
end if;

return excelence_point;
end//
DELIMITER ;

SELECT DISTINCT year, contest_levels.name as 'level', place, contests.name, contest_levels.id,
excelence_point(school_id,year,contests.id,contest_levels.id, region, place) as body
FROM contest_results, contest_levels, contests
WHERE contest_results.school_id=1
 AND contest_results.contest_level_id=contest_levels.id
 AND contest_results.contest_id=contests.id
ORDER BY year DESC, body DESC, contest_levels.id DESC, contests.name, place
