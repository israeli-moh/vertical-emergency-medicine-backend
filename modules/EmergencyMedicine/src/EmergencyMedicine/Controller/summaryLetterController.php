<?php

namespace EmergencyMedicine\Controller;



use ClinikalAPI\Model\GetTemplatesServiceTable;
use FhirAPI\FhirRestApiBuilder\Parts\ErrorCodes;
use FhirAPI\FhirRestApiBuilder\Parts\Strategy\StrategyElement\ValueSet\ValueSet;
use GenericTools\Model\FormEncounterTable;
use GenericTools\Model\Lists;
use GenericTools\Model\ListsOpenEmrTable;
use GenericTools\Model\ListsTable;
use GenericTools\Model\ValueSetsTable;
use Interop\Container\ContainerInterface;
use ClinikalAPI\Controller\PdfBaseController;

class summaryLetterController extends PdfBaseController
{
    const CATEGORY = "5"; //Referral for Summary

    public $container = null;
    public $FhirValueSet;

    public function __construct(ContainerInterface $container, array $post = array())
    {
        parent::__construct($container);
        $this->container = $container;
        $this->setPostData($post);
        $this->getXrayType();
        $valueSetParams = array('paramsFromUrl' => array(), 'paramsFromBody' => array(), 'container' => $this->container);
        $this->FhirValueSet = new ValueSet($valueSetParams);
    }


    public function getIsolationState(){
        //form_medical_admission_questionnaire.answer
        //where form_id =  encounter = <ENC_ID>, qid = 4 )
        return $this->getQData(1,'FormMedicalAdmissionQuestionnaireMapTable');
    }

    public function getIsolationInstructionsState(){
        //form_medical_admission_questionnaire.answer
        //where form_id =  encounter = <ENC_ID>, qid = 4 )
        return $this->getQData(2,'FormMedicalAdmissionQuestionnaireMapTable');
    }
    public function getNursingAnamnesisState(){
        //form_medical_admission_questionnaire.answer
        //where form_id =  encounter = <ENC_ID>, qid = 4 )
        return $this->getQData(3,'FormMedicalAdmissionQuestionnaireMapTable');
    }

    public function getPregnancyState(){
        //form_medical_admission_questionnaire.answer
        //where form_id =  encounter = <ENC_ID>, qid = 4 )
        return $this->getQData(4,'FormMedicalAdmissionQuestionnaireMapTable');
    }

    public function getMedicalHostoryComment(){
        //form_medical_admission_questionnaire.answer
        //where form_id =  encounter = <ENC_ID>, qid = 4 )
        return $this->getQData(8,'FormMedicalAdmissionQuestionnaireMapTable');
    }

    public function getFindings(){
        //form_medical_admission_questionnaire.answer
        //where form_id =  encounter = <ENC_ID>, qid = 2 )
        return $this->getQData(2,'FormDiagnosisAndRecommendationsQuestionnaireMapTable');
    }

    public function getDiagnostics(){
        //form_diagnosis_and_recommendations_questionnaire.answer
        //where encounter = <ENC_ID>, qid = 1 )
        return $this->getQData(1,'FormDiagnosisAndRecommendationsQuestionnaireMapTable');
    }

    public function getDiagnosis(){
        //form_diagnosis_and_recommendations_questionnaire.answer
        //where encounter = <ENC_ID>, qid = 1 )
        $codes = explode('|',$this->getQData(8,'FormDiagnosisAndRecommendationsQuestionnaireMapTable'));
        $titles = [];
        foreach ($codes as $code) {
            if (!empty($code)) {
                $titles[] = [
                    'code' => $code,
                    'title' => $this->getValueSetTitle('bk_diseases', $code)
                ];
            }

        }
        return $titles;
    }

    public function getDiagnosisListLang() {
        $valuesetTable = $this->container->get(ValueSetsTable::class);
        return $valuesetTable->getValueSetInfo('bk_diseases')['language'];

    }

    public function getValueSetTitle($listName,$value,$operations='$expand')
    {
        $this->FhirValueSet->setOperations(array($operations));
        $this->FhirValueSet->setParamsFromUrl(array($listName));
        $this->FhirValueSet->setParamsFromBody(array('PARAMETERS_FOR_SEARCH_RESULT'=>array ('filter' => array (0 => array ('value' => $value, 'operator' => '=',),),)));
        $ValueSetRez = $this->FhirValueSet->read();
        $expansion=$ValueSetRez->getExpansion();
        //$display=$expansion['contains'][0]['display']->getValue();
        return $expansion->getContains()[0]->getDisplay()->getValue();
    }

    public function getTreatmentDetails(){
        //form_diagnosis_and_recommendations_questionnaire.answer
        //where encounter = <ENC_ID>, qid = 1 )
        return $this->getQData(3,'FormDiagnosisAndRecommendationsQuestionnaireMapTable');
    }
    public function getRecommendationsOnRelease(){
        //form_diagnosis_and_recommendations_questionnaire.answer
        //where encounter = <ENC_ID>, qid = 1 )
        return $this->getQData(4,'FormDiagnosisAndRecommendationsQuestionnaireMapTable');
    }
    public function getDecisionOnRelease(){
        return $this->getQData(5,'FormDiagnosisAndRecommendationsQuestionnaireMapTable');
    }

    public function getReleaseDate(){
        return  ['day'=>date('d/m/Y'),"hour"=>date('H:i')];
    }

    public function getEvacuationWay(){
        return $this->getQData(6,'FormDiagnosisAndRecommendationsQuestionnaireMapTable');
    }

    public function getSickLeave(){
        return $this->getQData(7,'FormDiagnosisAndRecommendationsQuestionnaireMapTable');
    }



    private function getEmergencySummaryLetterData($patientData){
        $data = [];
        $reason_for_refferal = $this->getServiceTypeAndReasonCodeArray();

        $data['encounter_date'] = $this->getEncounterStartDate($this->postData['encounter']);
        $data['reason_for_refferal'] = $reason_for_refferal['service_and_reason'];
        $data['reason_for_refferal_details'] = $reason_for_refferal['details'];

        $data['insulation'] = $this->getIsolationState();
        $data['insulation_instructions'] = $this->getIsolationInstructionsState();
        $data['nursing_anamnesis'] = $this->getNursingAnamnesisState();
        $data['pregnant'] = $this->getPregnancyState($patientData);
        $data['sensitivities'] = $this->getSensitivities();
        $data['background_diseases'] = $this->getMedicalProblems();
        $data['chronic_medications'] = $this->getMedicine();
        $data['medical_history_comment'] = $this->getMedicalHostoryComment();
        $data['constants_indicators'] = $this->getConstantVitals($this->postData['encounter'],$this->postData['patient'],'exam',1,"date DESC");
        $data['variable_indicators'] =  $this->getVariantVitals($this->postData['encounter'],$this->postData['patient'],'vital-signs',1,"date DESC");
        $data['findings'] =str_replace("\n","<br/>",
                                       str_replace("\r\n","<br/>",$this->getFindings()));
        $data['diagnostics'] =str_replace("\n","<br/>",
                                       str_replace("\r\n","<br/>",$this->getDiagnostics()));
        $data['diagnosis'] = $this->getDiagnosis();
        $data['diagnosisListLage'] = $this->getDiagnosisListLang();
        $data['treatment_details'] =str_replace("\n","<br/>",
            str_replace("\r\n","<br/>",$this->getTreatmentDetails()));
        $data['recommendations_on_release'] =str_replace("\n","<br/>",
            str_replace("\r\n","<br/>",$this->getRecommendationsOnRelease()));
        $data['service_requests']=$this->getServiceRequest($this->postData['encounter'],$this->postData['patient'],'completed',$this->postData['x_ray_type']);
        $data['recommendations_for_medications']=$this->getPrescriptions($this->postData['encounter'],$this->postData['patient']);
        $data['decision_on_release']=str_replace("\n","<br/>",
            str_replace("\r\n","<br/>",$this->getDecisionOnRelease()));;
        $data['release_date']=str_replace("\n","<br/>",
            str_replace("\r\n","<br/>",$this->getReleaseDate()));;
        $data['evacuation_way']=str_replace("\n","<br/>",
            str_replace("\r\n","<br/>",$this->getEvacuationWay()));;
        $data['sick_leave']=str_replace("\n","<br/>",
            str_replace("\r\n","<br/>",$this->getSickLeave()));;

        return $data;
    }

    private function getXrayType(){
        $x_ray_type = $this->getTitleOfOptionFromListTable("x_ray_types",$this->postData['x_ray_type']);
        $this->postData['x_ray_type'] = $x_ray_type;
    }

    public function setPostData(array $data)
    {
        $this->postData = $data;
    }

    public function getPostData()
    {
        return $this->postData;
    }

    public function pdfAction()
    {

        $postData = $this->getPostData();


        $configData = $this->createConfigData($postData, self::PDF_MINE_TYPE, self::CATEGORY);

        if (empty($configData)) {
            ErrorCodes::http_response_code('500', 'facility or encounter missing');
            return array();
        }

        $facilityInfo = $this->getFacilityInfo($postData['facility']);
        $letterName = $postData['name_of_letter'];
        $headerData = array_merge($postData, $facilityInfo);

        $date = date('Y-m-d H:i:s');

        $patientData=$this->getPatientInfo($postData['patient']);
        $doctorData=$this->getUserInfo($this->getQuestionareUpdatedUser($this->postData['encounter'],'diagnosis_and_recommendations_questionnaire'));
        $bodyData = $this->getEmergencySummaryLetterData($patientData);

        $pdfSummaryBodyData = array(
            'clientReqData' => $postData,
            'patientData'=>$patientData,
            'doctorData'=>$doctorData,
            'bodyData'=>$bodyData
        );

        $drug_form= $this->getDrugForm();


        $bodyPath= ['emergency-medicine/summary-letter/summary-letter'];
        $bodyParsedData = [$pdfSummaryBodyData];

        if(!empty($bodyData['recommendations_for_medications'])) {
            // attach prescriotion
            $bodyPath[] = 'emergency-medicine/prescription-letter/prescription-letter';
            $postData['name_of_letter'] = 'Prescription';
            $pdfPrescriptionBodyData = array(
                'clientReqData' => $postData,
                'patientData'=>$patientData,
                'doctorData'=>$doctorData,
                'bodyData'=>[
                    "prescription"=>$bodyData['recommendations_for_medications'],
                    "route"=>$this->getDrugRoute(),
                    "interval"=>$this->getDrugInterval(),
                    "form"=>$drug_form,
                    "forms"=>$this->getDrugForms($drug_form),
                ]
            );
            $bodyParsedData[] = $pdfPrescriptionBodyData;
        }

        $pdfPrescriptionBodyData['clientReqData']['name_of_letter'] = "Prescription";
        $fileName = "{$postData['letter_type']}_patient_{$postData['patient']}_$date.pdf";

        //create multi paged pdf usinf letter creator.
        $pdfEncoded = $this->createBase64Pdf($fileName,$bodyPath, self::HEADER_PATH, self::FOOTER_PATH, $headerData,$bodyParsedData);

        $storageSave = $this->saveDocToStorage($pdfEncoded, $fileName, $date);  //timestamp is added later

        return $this->saveDocInfoToDb($storageSave, $configData, $pdfEncoded, $fileName);         //save doc info to db

    }

}
