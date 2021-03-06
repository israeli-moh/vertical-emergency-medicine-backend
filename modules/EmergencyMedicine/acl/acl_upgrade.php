<?php

use OpenEMR\Common\Acl\AclExtended;

return $ACL_UPGRADE = array(

    '0.2.0' => function () {

        $admin_write = AclExtended::getAclIdNumber('Administrators', 'write');
        $emergency_clinic_manager_write =AclExtended::addNewACL('Emergency manager', 'emergency_clinic_manager', 'write', 'Things that emergency clinic manager can modify');
        $emergency_clinic_manager_view =AclExtended::addNewACL('Emergency manager', 'emergency_clinic_manager', 'view', 'Things that emergency clinic manager can read but not modify');
        $emergency_receptionist_write =AclExtended::addNewACL('Emergency receptionist', 'emergency_receptionist', 'write', 'Things that emergency receptionist can modify');
        $emergency_receptionist_view =AclExtended::addNewACL('Emergency receptionist', 'emergency_receptionist', 'view', 'Things that emergency receptionist can read but not modify');
        $emergency_nurse_write =AclExtended::addNewACL('Emergency nurse', 'emergency_nurse', 'write', 'Things that emergency nurse can modify');
        $emergency_nurse_view =AclExtended::addNewACL('Emergency nurse', 'emergency_nurse', 'view', 'Things that emergency nurse can read but not modify');
        $emergency_doctor_write =AclExtended::addNewACL('Emergency doctor', 'emergency_doctor', 'write', 'Things that emergency doctor can modify');
        $emergency_doctor_view =AclExtended::addNewACL('Emergency doctor', 'emergency_doctor', 'view', 'Things that emergency doctor can read but not modify');

        AclExtended::addObjectAcl('client_app', 'Client Application', 'MedicalAdmissionForm','Medical Admission Form');
        AclExtended::addObjectAcl('client_app', 'Client Application', 'TestsandTreatmentsForm','Tests and Treatments Form');
        AclExtended::addObjectAcl('client_app', 'Client Application', 'DiagnosisandRecommendationsForm','Diagnosis and Recommendations Form');
        AclExtended::addObjectAcl('client_app', 'Client Application', 'SummaryLetter','Summary Letter');
        AclExtended::addObjectAcl('client_app', 'Client Application', 'EncountersReport','Encounters Report');
        AclExtended::addObjectAcl('client_app', 'Client Application', 'UnidentifiedPatient','Unidentified Patient');

        AclExtended::addObjectAcl('client_app', 'Client Application', 'PatientTrackingWaitingForNurse','Patient Tracking Waiting for Nurse');
        AclExtended::addObjectAcl('client_app', 'Client Application', 'PatientTrackingWaitingForDoctor','Patient Tracking Waiting for Doctor');
        AclExtended::addObjectAcl('client_app', 'Client Application', 'PatientTrackingWaitingForXray','Patient Tracking Waiting for Xray');
        AclExtended::addObjectAcl('client_app', 'Client Application', 'PatientTrackingWaitingForRelease','Patient Tracking Waiting for Release');
        AclExtended::addObjectAcl('client_app', 'Client Application', 'PatientTrackingFinishedVisit','Patient Tracking Finished visit');

        // client app ACL

        //Admin
        AclExtended::updateAcl($admin_write, 'Administrators', 'client_app', 'Client Application', 'SuperUser','Super User', 'write');

        //Emergency manager ACL
        AclExtended::updateAcl($emergency_clinic_manager_write, 'Emergency manager', 'client_app', 'Client Application', 'PatientTrackingWaitingForNurse','Patient Tracking Waiting for Nurse', 'write');
        AclExtended::updateAcl($emergency_clinic_manager_write, 'Emergency manager', 'client_app', 'Client Application', 'PatientTrackingWaitingForDoctor','Patient Tracking Waiting for Doctor', 'write');
        AclExtended::updateAcl($emergency_clinic_manager_write, 'Emergency manager', 'client_app', 'Client Application', 'PatientTrackingWaitingForXray','Patient Tracking Waiting for Xray', 'write');
        AclExtended::updateAcl($emergency_clinic_manager_write, 'Emergency manager', 'client_app', 'Client Application', 'PatientTrackingWaitingForRelease','Patient Tracking Waiting for Release', 'write');
        AclExtended::updateAcl($emergency_clinic_manager_write, 'Emergency manager', 'client_app', 'Client Application', 'PatientTrackingFinishedVisit','Patient Tracking Finished visit', 'write');
        AclExtended::updateAcl($emergency_clinic_manager_view, 'Emergency manager', 'client_app', 'Client Application', 'SearchPatient','Search Patient', 'view');
        AclExtended::updateAcl($emergency_clinic_manager_write, 'Emergency manager', 'client_app', 'Client Application', 'AddPatient','Add Patient', 'write');
        AclExtended::updateAcl($emergency_clinic_manager_write, 'Emergency manager', 'client_app', 'Client Application', 'PatientAdmission','Patient Admission', 'write');
        AclExtended::updateAcl($emergency_clinic_manager_view, 'Emergency manager', 'client_app', 'Client Application', 'AppointmentsAndEncounters','Appointments And Encounters', 'view');
        AclExtended::updateAcl($emergency_clinic_manager_view, 'Emergency manager', 'client_app', 'Client Application', 'EncounterSheet','Encounter Sheet', 'view');

        AclExtended::updateAcl($emergency_clinic_manager_view, 'Emergency manager', 'client_app', 'Client Application', 'MedicalAdmissionForm','Medical Admission Form', 'view');
        AclExtended::updateAcl($emergency_clinic_manager_view, 'Emergency manager', 'client_app', 'Client Application', 'TestsandTreatmentsForm','Tests and Treatments Form', 'view');
        AclExtended::updateAcl($emergency_clinic_manager_view, 'Emergency manager', 'client_app', 'Client Application', 'DiagnosisandRecommendationsForm','Diagnosis and Recommendations Form', 'view');
        AclExtended::updateAcl($emergency_clinic_manager_view, 'Emergency manager', 'client_app', 'Client Application', 'SummaryLetter','Summary Letter', 'view');
        AclExtended::updateAcl($emergency_clinic_manager_view, 'Emergency manager', 'client_app', 'Client Application', 'EncountersReport','Encounters Report', 'view');
        AclExtended::updateAcl($emergency_clinic_manager_write, 'Emergency manager', 'client_app', 'Client Application', 'UnidentifiedPatient','Unidentified Patient', 'write');

        AclExtended::updateAcl($emergency_clinic_manager_view, 'Emergency manager', 'clinikal_api', 'Client Application', 'general_settings','General settings', 'view');
        AclExtended::updateAcl($emergency_clinic_manager_view, 'Emergency manager', 'clinikal_api', 'Client Application', 'lists','Lists', 'view');


        // FHIR ACL
        AclExtended::updateAcl($emergency_clinic_manager_write, 'Emergency manager', 'fhir_api', 'FHIR API', 'patient','Patient', 'write');
        AclExtended::updateAcl($emergency_clinic_manager_write, 'Emergency manager', 'fhir_api', 'FHIR API', 'appointment','Appointment', 'write');
        AclExtended::updateAcl($emergency_clinic_manager_write, 'Emergency manager', 'fhir_api', 'FHIR API', 'encounter','Encounter', 'write');
        AclExtended::updateAcl($emergency_clinic_manager_view, 'Emergency manager', 'fhir_api', 'FHIR API', 'practitioner','Practitioner', 'view');
        AclExtended::updateAcl($emergency_clinic_manager_view, 'Emergency manager', 'fhir_api', 'FHIR API', 'organization','Organization', 'view');
        AclExtended::updateAcl($emergency_clinic_manager_view, 'Emergency manager', 'fhir_api', 'FHIR API', 'healthcareservice','Healthcareb Service', 'view');
        AclExtended::updateAcl($emergency_clinic_manager_view, 'Emergency manager', 'fhir_api', 'FHIR API', 'valueset','Value Set', 'view');
        AclExtended::updateAcl($emergency_clinic_manager_write, 'Emergency manager', 'fhir_api', 'FHIR API', 'relatedperson','Related Person', 'write');
        AclExtended::updateAcl($emergency_clinic_manager_write, 'Emergency manager', 'fhir_api', 'FHIR API', 'documentreference','Document Reference', 'write');
        AclExtended::updateAcl($emergency_clinic_manager_write, 'Emergency manager', 'fhir_api', 'FHIR API', 'questionnaire','Questionnaire', 'write');
        AclExtended::updateAcl($emergency_clinic_manager_write, 'Emergency manager', 'fhir_api', 'FHIR API', 'questionnaireresponse','Questionnaire Response', 'write');
        AclExtended::updateAcl($emergency_clinic_manager_view, 'Emergency manager', 'fhir_api', 'FHIR API', 'condition','Condition', 'view');
        AclExtended::updateAcl($emergency_clinic_manager_view, 'Emergency manager', 'fhir_api', 'FHIR API', 'medicationstatement','Medication Statement Response', 'view');
        AclExtended::updateAcl($emergency_clinic_manager_view, 'Emergency manager', 'fhir_api', 'FHIR API', 'observation','Observation', 'view');
        AclExtended::updateAcl($emergency_clinic_manager_view, 'Emergency manager', 'fhir_api', 'FHIR API', 'medicationrequest','MedicationRequest', 'view');
        AclExtended::updateAcl($emergency_clinic_manager_view, 'Emergency manager', 'fhir_api', 'FHIR API', 'servicerequest','ServiceRequest', 'view');


        //Emergency receptionist ACL
        // client app ACL
        AclExtended::updateAcl($emergency_receptionist_write, 'Emergency receptionist', 'client_app', 'Client Application', 'PatientTrackingWaitingForNurse','Patient Tracking Waiting for Nurse', 'write');
        AclExtended::updateAcl($emergency_receptionist_write, 'Emergency receptionist', 'client_app', 'Client Application', 'PatientTrackingWaitingForDoctor','Patient Tracking Waiting for Doctor', 'write');
        AclExtended::updateAcl($emergency_receptionist_write, 'Emergency receptionist', 'client_app', 'Client Application', 'PatientTrackingWaitingForXray','Patient Tracking Waiting for Xray', 'write');
        AclExtended::updateAcl($emergency_receptionist_write, 'Emergency receptionist', 'client_app', 'Client Application', 'PatientTrackingWaitingForRelease','Patient Tracking Waiting for Release', 'write');
        AclExtended::updateAcl($emergency_receptionist_write, 'Emergency receptionist', 'client_app', 'Client Application', 'PatientTrackingFinishedVisit','Patient Tracking Finished visit', 'write');
        AclExtended::updateAcl($emergency_receptionist_view, 'Emergency receptionist', 'client_app', 'Client Application', 'SearchPatient','Search Patient', 'view');
        AclExtended::updateAcl($emergency_receptionist_write, 'Emergency receptionist', 'client_app', 'Client Application', 'AddPatient','Add Patient', 'write');
        AclExtended::updateAcl($emergency_receptionist_write, 'Emergency receptionist', 'client_app', 'Client Application', 'PatientAdmission','Patient Admission', 'write');
        AclExtended::updateAcl($emergency_receptionist_view, 'Emergency receptionist', 'client_app', 'Client Application', 'AppointmentsAndEncounters','Appointments And Encounters', 'view');
        AclExtended::updateAcl($emergency_receptionist_view, 'Emergency receptionist', 'client_app', 'Client Application', 'EncounterSheet','Encounter Sheet', 'view');

        AclExtended::updateAcl($emergency_receptionist_view, 'Emergency receptionist', 'client_app', 'Client Application', 'MedicalAdmissionForm','Medical Admission Form', 'view');
        AclExtended::updateAcl($emergency_receptionist_view, 'Emergency receptionist', 'client_app', 'Client Application', 'TestsandTreatmentsForm','Tests and Treatments Form', 'view');
        AclExtended::updateAcl($emergency_receptionist_view, 'Emergency receptionist', 'client_app', 'Client Application', 'DiagnosisandRecommendationsForm','Diagnosis and Recommendations Form', 'view');
        AclExtended::updateAcl($emergency_receptionist_view, 'Emergency receptionist', 'client_app', 'Client Application', 'SummaryLetter','Summary Letter', 'view');
        AclExtended::updateAcl($emergency_receptionist_view, 'Emergency receptionist', 'client_app', 'Client Application', 'EncountersReport','Encounters Report', 'view');
        AclExtended::updateAcl($emergency_receptionist_write, 'Emergency receptionist', 'client_app', 'Client Application', 'UnidentifiedPatient','Unidentified Patient', 'write');

        AclExtended::updateAcl($emergency_receptionist_view, 'Emergency receptionist', 'clinikal_api', 'Clinikal API', 'general_settings','General settings', 'view');
        AclExtended::updateAcl($emergency_receptionist_view, 'Emergency receptionist', 'clinikal_api', 'Clinikal API', 'lists','Lists', 'view');

        // FHIR ACL
        AclExtended::updateAcl($emergency_receptionist_write, 'Emergency receptionist', 'fhir_api', 'FHIR API', 'patient','Patient', 'write');
        AclExtended::updateAcl($emergency_receptionist_write, 'Emergency receptionist', 'fhir_api', 'FHIR API', 'appointment','Appointment', 'write');
        AclExtended::updateAcl($emergency_receptionist_write, 'Emergency receptionist', 'fhir_api', 'FHIR API', 'encounter','Encounter', 'write');
        AclExtended::updateAcl($emergency_receptionist_view, 'Emergency receptionist', 'fhir_api', 'FHIR API', 'practitioner','Practitioner', 'view');
        AclExtended::updateAcl($emergency_receptionist_view, 'Emergency receptionist', 'fhir_api', 'FHIR API', 'organization','Organization', 'view');
        AclExtended::updateAcl($emergency_receptionist_view, 'Emergency receptionist', 'fhir_api', 'FHIR API', 'healthcareservice','Healthcareb Service', 'view');
        AclExtended::updateAcl($emergency_receptionist_view, 'Emergency receptionist', 'fhir_api', 'FHIR API', 'valueset','Value Set', 'view');
        AclExtended::updateAcl($emergency_receptionist_write, 'Emergency receptionist', 'fhir_api', 'FHIR API', 'relatedperson','Related Person', 'write');
        AclExtended::updateAcl($emergency_receptionist_write, 'Emergency receptionist', 'fhir_api', 'FHIR API', 'documentreference','Document Reference', 'write');
        AclExtended::updateAcl($emergency_receptionist_write, 'Emergency receptionist', 'fhir_api', 'FHIR API', 'questionnaire','Questionnaire', 'write');
        AclExtended::updateAcl($emergency_receptionist_write, 'Emergency receptionist', 'fhir_api', 'FHIR API', 'questionnaireresponse','Questionnaire Response', 'write');
        AclExtended::updateAcl($emergency_receptionist_view, 'Emergency receptionist', 'fhir_api', 'FHIR API', 'condition','Condition', 'view');
        AclExtended::updateAcl($emergency_receptionist_view, 'Emergency receptionist', 'fhir_api', 'FHIR API', 'medicationstatement','Medication Statement Response', 'view');
        AclExtended::updateAcl($emergency_receptionist_view, 'Emergency receptionist', 'fhir_api', 'FHIR API', 'observation','Observation', 'view');
        AclExtended::updateAcl($emergency_receptionist_view, 'Emergency receptionist', 'fhir_api', 'FHIR API', 'medicationrequest','MedicationRequest', 'view');
        AclExtended::updateAcl($emergency_receptionist_view, 'Emergency receptionist', 'fhir_api', 'FHIR API', 'servicerequest','ServiceRequest', 'view');


        //Emergency nurse ACL
        // client app ACL
        AclExtended::updateAcl($emergency_nurse_write, 'Emergency nurse', 'client_app', 'Client Application', 'PatientTrackingWaitingForNurse','Patient Tracking Waiting for Nurse', 'write');
        AclExtended::updateAcl($emergency_nurse_write, 'Emergency nurse', 'client_app', 'Client Application', 'PatientTrackingWaitingForDoctor','Patient Tracking Waiting for Doctor', 'write');
        AclExtended::updateAcl($emergency_nurse_write, 'Emergency nurse', 'client_app', 'Client Application', 'PatientTrackingWaitingForXray','Patient Tracking Waiting for Xray', 'write');
        AclExtended::updateAcl($emergency_nurse_write, 'Emergency nurse', 'client_app', 'Client Application', 'PatientTrackingWaitingForRelease','Patient Tracking Waiting for Release', 'write');
        AclExtended::updateAcl($emergency_nurse_write, 'Emergency nurse', 'client_app', 'Client Application', 'PatientTrackingFinishedVisit','Patient Tracking Finished visit', 'write');
        AclExtended::updateAcl($emergency_nurse_view, 'Emergency nurse', 'client_app', 'Client Application', 'SearchPatient','Search Patient', 'view');
        //AclExtended::updateAcl($emergency_nurse_write, 'Emergency nurse', 'client_app', 'Client Application', 'AddPatient','Add Patient', 'write');
        //AclExtended::updateAcl($emergency_nurse_write, 'Emergency nurse', 'client_app', 'Client Application', 'PatientAdmission','Patient Admission', 'write');
        AclExtended::updateAcl($emergency_nurse_view, 'Emergency nurse', 'client_app', 'Client Application', 'AppointmentsAndEncounters','Appointments And Encounters', 'view');
        AclExtended::updateAcl($emergency_nurse_view, 'Emergency nurse', 'client_app', 'Client Application', 'EncounterSheet','Encounter Sheet', 'view');

        AclExtended::updateAcl($emergency_nurse_write, 'Emergency nurse', 'client_app', 'Client Application', 'MedicalAdmissionForm','Medical Admission Form', 'write');
        AclExtended::updateAcl($emergency_nurse_write, 'Emergency nurse', 'client_app', 'Client Application', 'TestsandTreatmentsForm','Tests and Treatments Form', 'write');
        AclExtended::updateAcl($emergency_nurse_view, 'Emergency nurse', 'client_app', 'Client Application', 'DiagnosisandRecommendationsForm','Diagnosis and Recommendations Form', 'view');
        AclExtended::updateAcl($emergency_nurse_view, 'Emergency nurse', 'client_app', 'Client Application', 'SummaryLetter','Summary Letter', 'view');
        AclExtended::updateAcl($emergency_nurse_view, 'Emergency nurse', 'client_app', 'Client Application', 'EncountersReport','Encounters Report', 'view');
        AclExtended::updateAcl($emergency_nurse_write, 'Emergency nurse', 'client_app', 'Client Application', 'UnidentifiedPatient','Unidentified Patient', 'write');
        AclExtended::updateAcl($emergency_nurse_view, 'Emergency nurse', 'clinikal_api', 'Clinikal API', 'general_settings','General settings', 'view');
        AclExtended::updateAcl($emergency_nurse_view, 'Emergency nurse', 'clinikal_api', 'Clinikal API', 'lists','Lists', 'view');


        // FHIR ACL
        AclExtended::updateAcl($emergency_nurse_write, 'Emergency nurse', 'fhir_api', 'FHIR API', 'patient','Patient', 'write');
        AclExtended::updateAcl($emergency_nurse_view, 'Emergency nurse', 'fhir_api', 'FHIR API', 'appointment','Appointment', 'view');
        AclExtended::updateAcl($emergency_nurse_write, 'Emergency nurse', 'fhir_api', 'FHIR API', 'encounter','Encounter', 'write');
        AclExtended::updateAcl($emergency_nurse_view, 'Emergency nurse', 'fhir_api', 'FHIR API', 'practitioner','Practitioner', 'view');
        AclExtended::updateAcl($emergency_nurse_view, 'Emergency nurse', 'fhir_api', 'FHIR API', 'organization','Organization', 'view');
        AclExtended::updateAcl($emergency_nurse_view, 'Emergency nurse', 'fhir_api', 'FHIR API', 'healthcareservice','Healthcareb Service', 'view');
        AclExtended::updateAcl($emergency_nurse_view, 'Emergency nurse', 'fhir_api', 'FHIR API', 'valueset','Value Set', 'view');
        AclExtended::updateAcl($emergency_nurse_write, 'Emergency nurse', 'fhir_api', 'FHIR API', 'relatedperson','Related Person', 'write');
        AclExtended::updateAcl($emergency_nurse_write, 'Emergency nurse', 'fhir_api', 'FHIR API', 'documentreference','Document Reference', 'write');
        AclExtended::updateAcl($emergency_nurse_write, 'Emergency nurse', 'fhir_api', 'FHIR API', 'questionnaire','Questionnaire', 'write');
        AclExtended::updateAcl($emergency_nurse_write, 'Emergency nurse', 'fhir_api', 'FHIR API', 'questionnaireresponse','Questionnaire Response', 'write');
        AclExtended::updateAcl($emergency_nurse_write, 'Emergency nurse', 'fhir_api', 'FHIR API', 'condition','Condition', 'write');
        AclExtended::updateAcl($emergency_nurse_write, 'Emergency nurse', 'fhir_api', 'FHIR API', 'medicationstatement','Medication Statement Response', 'write');
        AclExtended::updateAcl($emergency_nurse_write, 'Emergency nurse', 'fhir_api', 'FHIR API', 'observation','Observation', 'write');
        AclExtended::updateAcl($emergency_nurse_view, 'Emergency nurse', 'fhir_api', 'FHIR API', 'medicationrequest','MedicationRequest', 'view');
        AclExtended::updateAcl($emergency_nurse_write, 'Emergency nurse', 'fhir_api', 'FHIR API', 'servicerequest','ServiceRequest', 'write');

        //Emergency doctor ACL
        // client app ACL
        AclExtended::updateAcl($emergency_doctor_write, 'Emergency doctor', 'client_app', 'Client Application', 'PatientTrackingWaitingForNurse','Patient Tracking Waiting for Nurse', 'write');
        AclExtended::updateAcl($emergency_doctor_write, 'Emergency doctor', 'client_app', 'Client Application', 'PatientTrackingWaitingForDoctor','Patient Tracking Waiting for Doctor', 'write');
        AclExtended::updateAcl($emergency_doctor_write, 'Emergency doctor', 'client_app', 'Client Application', 'PatientTrackingWaitingForXray','Patient Tracking Waiting for Xray', 'write');
        AclExtended::updateAcl($emergency_doctor_write, 'Emergency doctor', 'client_app', 'Client Application', 'PatientTrackingWaitingForRelease','Patient Tracking Waiting for Release', 'write');
        AclExtended::updateAcl($emergency_doctor_write, 'Emergency doctor', 'client_app', 'Client Application', 'PatientTrackingFinishedVisit','Patient Tracking Finished visit', 'write');
        AclExtended::updateAcl($emergency_doctor_view, 'Emergency doctor', 'client_app', 'Client Application', 'SearchPatient','Search Patient', 'view');
        //AclExtended::updateAcl($emergency_doctor_write, 'Emergency doctor', 'client_app', 'Client Application', 'AddPatient','Add Patient', 'write');
        //AclExtended::updateAcl($emergency_doctor_write, 'Emergency doctor', 'client_app', 'Client Application', 'PatientAdmission','Patient Admission', 'write');
        AclExtended::updateAcl($emergency_doctor_view, 'Emergency doctor', 'client_app', 'Client Application', 'AppointmentsAndEncounters','Appointments And Encounters', 'view');
        AclExtended::updateAcl($emergency_doctor_view, 'Emergency doctor', 'client_app', 'Client Application', 'EncounterSheet','Encounter Sheet', 'view');

        AclExtended::updateAcl($emergency_doctor_write, 'Emergency doctor', 'client_app', 'Client Application', 'MedicalAdmissionForm','Medical Admission Form', 'write');
        AclExtended::updateAcl($emergency_doctor_write, 'Emergency doctor', 'client_app', 'Client Application', 'TestsandTreatmentsForm','Tests and Treatments Form', 'write');
        AclExtended::updateAcl($emergency_doctor_write, 'Emergency doctor', 'client_app', 'Client Application', 'DiagnosisandRecommendationsForm','Diagnosis and Recommendations Form', 'write');
        AclExtended::updateAcl($emergency_doctor_view, 'Emergency doctor', 'client_app', 'Client Application', 'SummaryLetter','Summary Letter', 'view');
        AclExtended::updateAcl($emergency_doctor_view, 'Emergency doctor', 'client_app', 'Client Application', 'EncountersReport','Encounters Report', 'view');
        AclExtended::updateAcl($emergency_doctor_write, 'Emergency doctor', 'client_app', 'Client Application', 'UnidentifiedPatient','Unidentified Patient', 'write');

        AclExtended::updateAcl($emergency_doctor_view, 'Emergency doctor', 'clinikal_api', 'Clinikal API', 'general_settings','General settings', 'view');
        AclExtended::updateAcl($emergency_doctor_view, 'Emergency doctor', 'clinikal_api', 'Clinikal API', 'lists','Lists', 'view');

        // FHIR ACL
        AclExtended::updateAcl($emergency_doctor_write, 'Emergency doctor', 'fhir_api', 'FHIR API', 'patient','Patient', 'write');
        AclExtended::updateAcl($emergency_doctor_view, 'Emergency doctor', 'fhir_api', 'FHIR API', 'appointment','Appointment', 'view');
        AclExtended::updateAcl($emergency_doctor_write, 'Emergency doctor', 'fhir_api', 'FHIR API', 'encounter','Encounter', 'write');
        AclExtended::updateAcl($emergency_doctor_view, 'Emergency doctor', 'fhir_api', 'FHIR API', 'practitioner','Practitioner', 'view');
        AclExtended::updateAcl($emergency_doctor_view, 'Emergency doctor', 'fhir_api', 'FHIR API', 'organization','Organization', 'view');
        AclExtended::updateAcl($emergency_doctor_view, 'Emergency doctor', 'fhir_api', 'FHIR API', 'healthcareservice','Healthcareb Service', 'view');
        AclExtended::updateAcl($emergency_doctor_view, 'Emergency doctor', 'fhir_api', 'FHIR API', 'valueset','Value Set', 'view');
        AclExtended::updateAcl($emergency_doctor_write, 'Emergency doctor', 'fhir_api', 'FHIR API', 'relatedperson','Related Person', 'write');
        AclExtended::updateAcl($emergency_doctor_write, 'Emergency doctor', 'fhir_api', 'FHIR API', 'documentreference','Document Reference', 'write');
        AclExtended::updateAcl($emergency_doctor_write, 'Emergency doctor', 'fhir_api', 'FHIR API', 'questionnaire','Questionnaire', 'write');
        AclExtended::updateAcl($emergency_doctor_write, 'Emergency doctor', 'fhir_api', 'FHIR API', 'questionnaireresponse','Questionnaire Response', 'write');
        AclExtended::updateAcl($emergency_doctor_write, 'Emergency doctor', 'fhir_api', 'FHIR API', 'condition','Condition', 'write');
        AclExtended::updateAcl($emergency_doctor_write, 'Emergency doctor', 'fhir_api', 'FHIR API', 'medicationstatement','Medication Statement Response', 'write');
        AclExtended::updateAcl($emergency_doctor_write, 'Emergency doctor', 'fhir_api', 'FHIR API', 'observation','Observation', 'write');
        AclExtended::updateAcl($emergency_doctor_write, 'Emergency doctor', 'fhir_api', 'FHIR API', 'medicationrequest','MedicationRequest', 'write');
        AclExtended::updateAcl($emergency_doctor_write, 'Emergency doctor', 'fhir_api', 'FHIR API', 'servicerequest','ServiceRequest', 'write');
    },
    '1.1.0' => function ()
    {
        $admin_write = AclExtended::getAclIdNumber('Administrators', 'write');
        $emergency_clinic_manager_write = AclExtended::addNewACL('Emergency manager', 'emergency_clinic_manager', 'write', 'Things that emergency clinic manager can modify');
        $emergency_clinic_manager_view = AclExtended::addNewACL('Emergency manager', 'emergency_clinic_manager', 'view', 'Things that emergency clinic manager can read but not modify');
        $emergency_receptionist_write = AclExtended::addNewACL('Emergency receptionist', 'emergency_receptionist', 'write', 'Things that emergency receptionist can modify');
        $emergency_receptionist_view = AclExtended::addNewACL('Emergency receptionist', 'emergency_receptionist', 'view', 'Things that emergency receptionist can read but not modify');
        $emergency_nurse_write = AclExtended::addNewACL('Emergency nurse', 'emergency_nurse', 'write', 'Things that emergency nurse can modify');
        $emergency_nurse_view = AclExtended::addNewACL('Emergency nurse', 'emergency_nurse', 'view', 'Things that emergency nurse can read but not modify');
        $emergency_doctor_write = AclExtended::addNewACL('Emergency doctor', 'emergency_doctor', 'write', 'Things that emergency doctor can modify');
        $emergency_doctor_view = AclExtended::addNewACL('Emergency doctor', 'emergency_doctor', 'view', 'Things that emergency doctor can read but not modify');

        AclExtended::addObjectAcl('client_app', 'Client Application', 'AddNewTreatmentInstruction','Adding new treatment instruction');
        AclExtended::updateAcl($emergency_doctor_write, 'Emergency doctor', 'client_app', 'Client Application', 'AddNewTreatmentInstruction','Adding new treatment instruction', 'write');

        AclExtended::updateAcl($emergency_clinic_manager_write, 'Emergency manager', 'client_app', 'Client Application', 'ManageTemplates','Manage Templates', 'write');
        AclExtended::updateAcl($emergency_clinic_manager_write, 'Emergency manager', 'menus', 'Menus', 'modle','Modules', 'write');

    }
);


