
-- GENERIC SQL NEED TO MOVE TO CLINIKALAPI MODULE
REPLACE INTO `facility` (`id`, `name`, `phone`, `fax`, `street`, `city`, `state`, `postal_code`, `country_code`, `federal_ein`, `website`, `email`, `service_location`, `billing_location`, `accepts_assignment`, `pos_code`, `x12_sender_id`, `attn`, `domain_identifier`, `facility_npi`, `tax_id_type`, `color`, `primary_business_entity`, `facility_code`, `extra_validation`, `facility_taxonomy`, `mail_street`, `mail_street2`, `mail_city`, `mail_state`, `mail_zip`, `oid`, `iban`, `info`, `active`)
VALUES
('5', 'כללית', NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, '1', '0', '0', '71', NULL, NULL, NULL, NULL, '', '#91AFFF', '0', NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '1'),
('6', 'מכבי', NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, '1', '0', '0', '71', NULL, NULL, NULL, NULL, '', '#92AFFF', '0', NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '1'),
('7', 'מאוחדת', NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, '1', '0', '0', '71', NULL, NULL, NULL, NULL, '', '#93AFFF', '0', NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '1'),
('8', 'לאומית', NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, '1', '0', '0', '71', NULL, NULL, NULL, NULL, '', '#94AFFF', '0', NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '1'),
('9', 'צה"ל', NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, '1', '0', '0', '71', NULL, NULL, NULL, NULL, '', '#95AFFF', '0', NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, '1');

UPDATE `list_options` SET `option_id` = '5' WHERE `list_options`.`list_id` = 'mh_ins_organizations' AND `list_options`.`option_id` = 'hmo_1';
UPDATE `list_options` SET `option_id` = '6' WHERE `list_options`.`list_id` = 'mh_ins_organizations' AND `list_options`.`option_id` = 'hmo_2';
UPDATE `list_options` SET `option_id` = '7' WHERE `list_options`.`list_id` = 'mh_ins_organizations' AND `list_options`.`option_id` = 'hmo_3';
UPDATE `list_options` SET `option_id` = '8' WHERE `list_options`.`list_id` = 'mh_ins_organizations' AND `list_options`.`option_id` = 'hmo_4';

INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `notes`,`activity`)
VALUES
('mh_ins_organizations', 'idf', 'IDF', '0', '0', '0','' ,'1');

ALTER TABLE facility AUTO_INCREMENT = 17;


INSERT INTO `questionnaires_schemas` (`qid`, `form_name`,`form_table`, `column_type`, `question`)
VALUES
('1', 'commitment_questionnaire','form_commitment_questionnaire', 'integer', 'Commitment number'),
('2', 'commitment_questionnaire','form_commitment_questionnaire', 'date', 'Commitment date'),
('3', 'commitment_questionnaire','form_commitment_questionnaire', 'date', 'Commitment expiration date'),
('4', 'commitment_questionnaire','form_commitment_questionnaire', 'string', 'Signing doctor'),
('5', 'commitment_questionnaire','form_commitment_questionnaire', 'integer', 'doctor license number'),
('6', 'commitment_questionnaire','form_commitment_questionnaire', 'string', 'Payment amount'),
('7', 'commitment_questionnaire','form_commitment_questionnaire', 'string', 'Payment method'),
('8', 'commitment_questionnaire','form_commitment_questionnaire', 'string', 'Receipt number');


INSERT INTO `registry` (`name`, `state`, `directory`, `sql_run`, `unpackaged`, `date`, `priority`, `category`, `nickname`, `patient_encounter`, `therapy_group_encounter`, `aco_spec`)
VALUES
('Commitment questionnaire', 1, 'commitment_questionnaire', 1, 1, '2020-03-14 00:00:00', 0, 'Clinical', '', 0, 0, 'encounters|notes');


-- --------------------------------------------------------

UPDATE `categories` SET `name` = 'HPatient Photograph', `lft` = '105', `rght` = '106' WHERE `id` = '4';
UPDATE `categories` SET `name` = 'EMedical Record', `lft` = '101', `rght` = '102' WHERE `id` = '2';
UPDATE `categories` SET `rght` = '271' WHERE `id` = '1';
UPDATE `categories` SET `name` = 'FLab Report', `lft` = '103', `rght` = '104' WHERE `id` = '3';

DELETE FROM `categories` WHERE `id` = '19';
DELETE FROM `categories` WHERE `id` = '22';
DELETE FROM `categories` WHERE `id` = '15';
DELETE FROM `categories` WHERE `id` = '14';
DELETE FROM `categories` WHERE `id` = '11';
DELETE FROM `categories` WHERE `id` = '21';
DELETE FROM `categories` WHERE `id` = '25';
DELETE FROM `categories` WHERE `id` = '20';
DELETE FROM `categories` WHERE `id` = '27';
DELETE FROM `categories` WHERE `id` = '6';
DELETE FROM `categories` WHERE `id` = '12';
DELETE FROM `categories` WHERE `id` = '24';
DELETE FROM `categories` WHERE `id` = '9';
DELETE FROM `categories` WHERE `id` = '10';
DELETE FROM `categories` WHERE `id` = '5';
DELETE FROM `categories` WHERE `id` = '8';
DELETE FROM `categories` WHERE `id` = '16';
DELETE FROM `categories` WHERE `id` = '17';
DELETE FROM `categories` WHERE `id` = '18';
DELETE FROM `categories` WHERE `id` = '13';
DELETE FROM `categories` WHERE `id` = '28';
DELETE FROM `categories` WHERE `id` = '7';
DELETE FROM `categories` WHERE `id` = '29';
DELETE FROM `categories` WHERE `id` = '26';
DELETE FROM `categories` WHERE `id` = '23';

DELETE FROM `categories_seq` WHERE `id` = '29';
INSERT INTO `categories_seq` (`id`) VALUES('9');


INSERT INTO `fhir_questionnaire` (`name`, `directory`, `state`, `aco_spec`) VALUES
('Commitment questionnaire', 'commitment_questionnaire', '1', 'encounters|notes');


/* INSERT LISTS*/
DELETE FROM list_options where list_id="clinikal_service_types" OR option_id="clinikal_service_types";
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`, `codes`, `toggle_setting_1`, `toggle_setting_2`, `activity`, `subtype`, `edit_options`) VALUES
('lists', 'clinikal_service_types', 'Clinikal Service Types', 0, 0, 0, '', '', '', 0, 0, 1, '', 1),
('clinikal_service_types', '1', 'Emergency Medicine', 10, 0, 0, '', '', '', 0, 0, 1, '', 1);


DELETE FROM list_options where list_id="clinikal_service_types" OR option_id="clinikal_service_types";
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `activity`,`notes`) VALUES
('lists', 'clinikal_reason_codes', 'Clinikal Reason Codes', 0, 1,'1'),
('clinikal_reason_codes', 'dehydration', 'Dehydration', 10, 1,'1'),
('clinikal_reason_codes', 'orthopedic_sabotage', 'Orthopedic sabotage', 20, 1,'1'),
('clinikal_reason_codes', 'head_injury', 'head injury', 30, 1,'1'),
('clinikal_reason_codes', 'foreign_body_penetration', 'Foreign body penetration', 40, 1,'1'),
('clinikal_reason_codes', 'high_temperature', 'high temperature', 50, 1,'1'),
('clinikal_reason_codes', 'cut', 'cut', 60, 1,'1'),
('clinikal_reason_codes', 'pain', 'Pain', 70, 1,'1'),
('clinikal_reason_codes', 'chest_pain', 'Chest pain', 80, 1,'1'),
('clinikal_reason_codes', 'back_pain', 'Back pain', 90, 1,'1'),
('clinikal_reason_codes', 'headache', 'Headache', 100, 1,'1'),
('clinikal_reason_codes', 'rash', 'Rash', 110, 1,'1'),
('clinikal_reason_codes', 'shortness_of_breath', 'Shortness of breath', 120, 1,'1'),
('clinikal_reason_codes', 'diarrhea_and_vomiting', 'Diarrhea and vomiting', 130, 1,'1');


INSERT INTO `code_types` (`ct_key`, `ct_id`, `ct_seq`, `ct_mod`, `ct_just`, `ct_mask`, `ct_fee`, `ct_rel`, `ct_nofs`, `ct_diag`, `ct_active`, `ct_label`, `ct_external`, `ct_claim`, `ct_proc`, `ct_term`, `ct_problem`, `ct_drug`) VALUES
('Sensitivities', 9920, 9920, 12, 'Sensitivities', '', 1, 0, 1, 1, 1, 'Sensitivities', 0, 1, 0, 1, 0, 0),
('BK Diseases', 9921, 9921, 12, 'BK Diseases', '', 1, 0, 1, 0, 1, 'Background Diseases', 0, 1, 0, 1, 1, 0);


INSERT INTO `codes` (`code_text`, `code_text_short`, `code`, `code_type`, `modifier`, `units`, `fee`, `superbill`, `related_code`, `taxrates`, `cyp_factor`, `active`, `reportable`, `financial_reporting`) VALUES
-- Sensitivities
('Eggs', '', '10', 9920, '', 0, '0.00', '', '', '', 0, 1, 0, 0),
('IodineI', '', '20', 9920, '', 0, '0.00', '', '', '', 0, 1, 0, 0),
('Lactose', '', '30', 9920, '', 0, '0.00', '', '', '', 0, 1, 0, 0),
('Neomycin', '', '40', 9920, '', 0, '0.00', '', '', '', 0, 1, 0, 0),
('Latex', '', '50', 9920, '', 0, '0.00', '', '', '', 0, 1, 0, 0),
('Penicillin', '', '60', 9920, '', 0, '0.00', '', '', '', 0, 1, 0, 0),
--  Background Diseases
("Alzheimer's", '', '10', 9921, '', 0, '0.00', '', '', '', 0, 1, 0, 0),
('Asthma', '', '20', 9921, '', 0, '0.00', '', '', '', 0, 1, 0, 0),
('High blood pressure', '', '30', 9921, '', 0, '0.00', '', '', '', 0, 1, 0, 0),
('Heart disease', '', '40', 9921, '', 0, '0.00', '', '', '', 0, 1, 0, 0),
('Diabetes', '', '50', 9921, '', 0, '0.00', '', '', '', 0, 1, 0, 0),
('Cancer', '', '60', 9921, '', 0, '0.00', '', '', '', 0, 1, 0, 0),
('Tuberculosis', '', '70', 9921, '', 0, '0.00', '', '', '', 0, 1, 0, 0);


INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `activity`,`notes`) VALUES
('lists', 'tests_and_treatments', 'Tests and Treatments', 0, 1,''),
('tests_and_treatments', 'dehydration', 'EGK', 10, 1,''),
('tests_and_treatments', 'inhalation', 'Inhalation', 20, 1,''),
('tests_and_treatments', 'laboratory_tests', 'Laboratory tests', 30, 1,''),
('tests_and_treatments', 'bandage', 'Bandage', 40, 1,'רכיב פשוט'),
('tests_and_treatments', 'taking_metrics', 'Taking metrics', 50, 1,''),
('tests_and_treatments', 'fluid_infusion', 'Fluid infusion', 60, 1,''),
('tests_and_treatments', 'providing_medicine', 'Providing medicine', 70, 1,''),
('tests_and_treatments', 'x_ray', 'X-Ray', 80, 1,'');

INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `activity`,`notes`) VALUES
('lists', 'x_ray_types', 'X-Ray Types', 0, 1,''),
('x_ray_types', 'dehydration', 'Chest', 10, 1,''),
('x_ray_types', 'inhalation', 'Palm', 20, 1,''),
('x_ray_types', 'laboratory_tests', 'sole', 30, 1,''),
('x_ray_types', 'bandage', 'Shoulder', 40, 1,''),
('x_ray_types', 'taking_metrics', 'Neck', 50, 1,''),
('x_ray_types', 'fluid_infusion', 'Ankle', 60, 1,'');

