
-- DROP TABLE tmp_exam_results;

DROP TABLE IF EXISTS tmp_exam_results;
CREATE TABLE tmp_exam_results LIKE exam_results;

INSERT INTO tmp_exam_results SELECT * from exam_results;



-- ----------------------------------------------------------------
-- cze_percentil
-- ----------------------------------------------------------------
UPDATE tmp_exam_results SET cze_percentil=(SELECT count(*) FROM exam_results a
                                   WHERE tmp_exam_results.year=a.year
                                     AND tmp_exam_results.subject=a.subject
                                     AND tmp_exam_results.type=a.type
                                     AND tmp_exam_results.specialization_group_id=a.specialization_group_id
                                     AND tmp_exam_results.percentil>a.percentil)*100/
                                   (SELECT count(*) FROM exam_results b
                                   WHERE tmp_exam_results.year=b.year
                                     AND tmp_exam_results.subject=b.subject
                                     AND tmp_exam_results.type=b.type
                                     AND tmp_exam_results.specialization_group_id=b.specialization_group_id);

-- ----------------------------------------------------------------
-- cze_median
-- ----------------------------------------------------------------
UPDATE tmp_exam_results SET cze_median=(SELECT count(*) FROM exam_results a
                                   WHERE tmp_exam_results.year=a.year
                                     AND tmp_exam_results.subject=a.subject
                                     AND tmp_exam_results.type=a.type
                                     AND tmp_exam_results.specialization_group_id=a.specialization_group_id
                                     AND tmp_exam_results.median>a.median)*100/
                                   (SELECT count(*) FROM exam_results b
                                   WHERE tmp_exam_results.year=b.year
                                     AND tmp_exam_results.subject=b.subject
                                     AND tmp_exam_results.type=b.type
                                     AND tmp_exam_results.specialization_group_id=b.specialization_group_id);
-- ----------------------------------------------------------------
-- cze_uspesnost
-- ----------------------------------------------------------------
UPDATE tmp_exam_results SET cze_uspesnost=(SELECT count(*) FROM exam_results a
                                   WHERE tmp_exam_results.year=a.year
                                     AND tmp_exam_results.subject=a.subject
                                     AND tmp_exam_results.type=a.type
                                     AND tmp_exam_results.specialization_group_id=a.specialization_group_id
                                     AND tmp_exam_results.uspelo/tmp_exam_results.prihlaseno>a.uspelo/a.prihlaseno)*100/
                                   (SELECT count(*) FROM exam_results b
                                   WHERE tmp_exam_results.year=b.year
                                     AND tmp_exam_results.subject=b.subject
                                     AND tmp_exam_results.type=b.type
                                     AND tmp_exam_results.specialization_group_id=b.specialization_group_id);
-- ----------------------------------------------------------------
-- cze_nepripusteno opačně znaménko
-- ----------------------------------------------------------------
UPDATE tmp_exam_results SET cze_nepripusteno=(SELECT count(*) FROM exam_results a
                                   WHERE tmp_exam_results.year=a.year
                                     AND tmp_exam_results.subject=a.subject
                                     AND tmp_exam_results.type=a.type
                                     AND tmp_exam_results.specialization_group_id=a.specialization_group_id
                                     AND tmp_exam_results.omluveno/tmp_exam_results.prihlaseno<a.omluveno/a.prihlaseno)*100/
                                   (SELECT count(*) FROM exam_results b
                                   WHERE tmp_exam_results.year=b.year
                                     AND tmp_exam_results.subject=b.subject
                                     AND tmp_exam_results.type=b.type
                                     AND tmp_exam_results.specialization_group_id=b.specialization_group_id);
-- ----------------------------------------------------------------
-- promítnutí změn do ostré tabulky exam_results
-- ----------------------------------------------------------------
UPDATE exam_results SET
cze_percentil=(SELECT cze_percentil FROM tmp_exam_results t WHERE t.id=exam_results.id)
cze_median=(SELECT cze_median FROM tmp_exam_results t WHERE t.id=exam_results.id)
cze_uspesnost=(SELECT cze_uspesnost FROM tmp_exam_results t WHERE t.id=exam_results.id)
cze_nepripusteno=(SELECT cze_nepripusteno FROM tmp_exam_results t WHERE t.id=exam_results.id);

DROP TABLE tmp_exam_results;
