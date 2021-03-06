<?php

namespace EmergencyMedicine\Controller;

use FhirAPI\FhirRestApiBuilder\Parts\ErrorCodes;
use Interop\Container\ContainerInterface;
use ClinikalAPI\Controller\PdfBaseController;
use OpenEMR\Common\Acl\AclMain;
use ReportTool\Controller\ReportInterface;
use ReportTool\Model\CustomDB;
use GenericTools\Controller\GenericToolsController;
use GenericTools\Model\RegistryTable;

use ReportTool\Controller\BaseController as ReportBase;

class EncounterReportContrller extends ReportBase implements ReportInterface
{
    const PROCEDURE_NAME = 'EncounterReport';
    const REPORT_ID = "encounter-report";
    const REPORT_TITLE = "Encounter report";
    const REPORT_ROUTE = "EncounterReport";
    const TABLE_COLUMNS_NAME = array(
        'encounter_date',
        'patient_name',
        'id',
        'insurance_body',
        'branch_name',
        'service_type',
        'decision',
        'release_way',
    );


    const REPORT_NAME = 'encounter_report_';
    const TAB_TITLE = 'EncounterReport';
    const FILE_NAME = 'encounter-report';
    const ALL_NUM = -1;
    const ALL_STRING = 'All';

    /*************************future FHIR search trait ***********************************/
    const ORGANIZATION = "Organization";
    const HEALTHCARE_SERVICE = "HealthcareService";

    const BRANCH_SEARCH = array(
        'REWRITE_COMMAND' => 'fhir/v4/Organization',
        'ARGUMENTS' => array(
            'type' => array(
                0 => array(
                    'value' => '11',
                    'operator' => null,
                    'modifier' => 'exact',
                ),
            ),
        )
    );
    const HMO_SEARCH = array(
        'REWRITE_COMMAND' => 'fhir/v4/Organization',
        'ARGUMENTS' => array(
            'type' => array(
                0 => array(
                    'value' => '71',
                    'operator' => null,
                    'modifier' => 'exact',
                ),
            ),
        )
    );

    const HC_Service_SEARCH = array(
        'REWRITE_COMMAND' => 'fhir/v4/HealthcareService',
        'ARGUMENTS' => array(
            'organization' => array(
                0 => array(
                    'value' => '0',
                    'operator' => null,
                    'modifier' => 'exact',
                ),
            ),
        )
    );

    const SERVICE_TYPES_SEARCH = array(0 => "service_types", 1 => '$expand');

    public function fhirSearch($container, $FHIRElement, $bodyParams)
    {
        $strategy = "FhirAPI\FhirRestApiBuilder\Parts\Strategy\StrategyElement\\$FHIRElement\\$FHIRElement";
        $params = ['paramsFromBody' => $bodyParams, 'paramsFromUrl' => array(), 'container' => $container];
        $obj = new $strategy($params);
        $search = $obj->search();
        return $search;
    }

    public function getValueSet($container, $name, $paramsFromUrl = array(), $bodyParams = array())
    {
        $strategy = "FhirAPI\FhirRestApiBuilder\Parts\Strategy\StrategyElement\\ValueSet\\ValueSet";
        $params = ['paramsFromBody' => $bodyParams, 'paramsFromUrl' => $paramsFromUrl, 'container' => $container];
        $obj = new $strategy($params);
        $valueSet = $obj->read();
        $codes = $this->getCodeArrayFromValueSet($valueSet);
        return $codes;
    }

    public function getCodeArrayFromValueSet($valueSet)
    {
        $codes = array();
        if (method_exists($valueSet, 'get_fhirElementName') && $valueSet->get_fhirElementName() === "ValueSet") {
            $contains = $valueSet->getExpansion()->getContains();
            foreach ($contains as $index => $codeInfo) {
                $codes[$codeInfo->getCode()->getValue()] = xlt($codeInfo->getDisplay()->getValue());
            }
        }
        return $codes;
    }


    public function extractFhirElmFromSearch($bundle, $FHIRElementName)
    {
        $fhirElmCollection = array();
        $entries = $bundle->getEntry();
        foreach ($entries as $key => $value) {
            $FHIRElmOBJ = $value->getResource();
            if (is_object($FHIRElmOBJ) && $FHIRElmOBJ->get_fhirElementName() === $FHIRElementName) {
                $fhirElmCollection[] = $FHIRElmOBJ;
            }
        }
        return $fhirElmCollection;
    }

    public function getBranchNames()
    {
        $branchList = array();
        $searchForBranch = $this->fhirSearch($this->container, self::ORGANIZATION, self::BRANCH_SEARCH);
        $searchElm = $this->extractFhirElmFromSearch($searchForBranch, self::ORGANIZATION);
        foreach ($searchElm as $key => $value) {
            $branchList[$value->getId()->getValue()] = $value->getName()->getValue();
        }
        return $branchList;
    }

    public function getHmoNames()
    {
        $hmoList = array();
        $searchForBranch = $this->fhirSearch($this->container, self::ORGANIZATION, self::HMO_SEARCH);
        $searchElm = $this->extractFhirElmFromSearch($searchForBranch, self::ORGANIZATION);
        foreach ($searchElm as $key => $value) {
            $hmoList[$value->getId()->getValue()] = $value->getName()->getValue();
        }
        return $hmoList;
    }

    public function getHealthcareServiceNames($branchNum)
    {
        $HealthCareServiceList = array();

        $serviceSerach = self::HC_Service_SEARCH;
        $serviceSerach['ARGUMENTS']['organization'][0]['value'] = $branchNum;
        $searchForHCS = $this->fhirSearch($this->container, self::HEALTHCARE_SERVICE, $serviceSerach);
        $searchElm = $this->extractFhirElmFromSearch($searchForHCS, self::HEALTHCARE_SERVICE);
        foreach ($searchElm as $key => $value) {
            $code = $value->getType()[0]->getCoding()[0]->getCode()->getValue();
            $name = $value->getName()->getValue();
            $HealthCareServiceList[$code] = $name;
        }
        return $HealthCareServiceList;
    }

    /***********************************************************************/

    public $container = null;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container, self::PROCEDURE_NAME);
        if(!AclMain::aclCheckCore('client_app', 'EncountersReport',false,'view')){
            exit('Access denied');
        }

        $this->container = $container;
    }

    public function indexAction()
    {
        $serviceTypeList = array();
        $branchList = $this->getBranchNames();
        $hmoList = $this->getHmoNames();

        if (count($branchList) <= 1) {

            if (count($branchList) === 1) {

                $serviceTypeList = $this->getHealthcareServiceNames(array_key_first($branchList));

            } else {
                $serviceTypeList[self::ALL_NUM] = xlt('All');
            }

            if (empty($branchList)) {
                $branchList[self::ALL_NUM] = xlt('All');
            }
            $this->addSelectFilter('branch_name', 'Branch name', $branchList, array_key_first($branchList), 230, false, false);
            $this->addSelectFilter('service_type', 'Service type', $serviceTypeList, array_key_first($serviceTypeList), 230, false, false);

        } else {
            $branchList[self::ALL_NUM] = xlt('All');
            $this->addSelectFilter('branch_name', 'Branch name', $branchList, self::ALL_NUM, 230, false, false);
            $serviceTypeList = $this->getValueSet($this->container, self::SERVICE_TYPES_SEARCH[0], self::SERVICE_TYPES_SEARCH);
            $serviceTypeList[self::ALL_NUM] = xlt('All');
            $this->addSelectFilter('service_type', 'Service type', $serviceTypeList, self::ALL_NUM, 230, false, false);
        }

        $hmoList[self::ALL_NUM] = xlt('All');
        $this->addSelectFilter('hmo', 'HMO', $hmoList, self::ALL_NUM, 230, false, false);

        //from date
        $this->addInputFilter('from_date', 'From date', 120, oeFormatShortDate(date('Y-m-d', strtotime('yesterday'))), true);
        //to date
        $this->addInputFilter('until_date', 'Until date', 120, oeFormatShortDate(), true);

        /*
        $doctorList = $this->AddSpecialFilters($doctorList, true, false, false);
        $eventStatusList=$this->getListsTable()->getListForViewForm(self::STATUS_LIST,false,array(),true,true);
        $eventStatusList = $this->AddSpecialFilters($eventStatusList, true, false, false);
        $patientNames= $this->AddSpecialFilters($eventStatusList, true, false, false);

        $this->addSelectFilter('attending_physician', 'Attending Physician', $doctorList, '-1', 240, false, false,'form-control simple-select');
        $this->addSelectFilter('patient_name', 'Patient Name', $patientNames, '-1', 350, false, false,'form-control simple-select');
        $this->addInputFilter('until_date', 'Until date', 120, oeFormatShortDate(date('Y-m-d')),false);
        */

        $this->renderHeader(xl(self::REPORT_TITLE), array());

        $data = [];

        //processFilters must be exactly as name of columns define below
        $data[self::COLUMNS] = self::TABLE_COLUMNS_NAME;
        $data[self::ID] = self::REPORT_ID;
        $data[self::TITLE] = self::REPORT_TITLE;
        $data[self::ROUTE] = self::REPORT_ROUTE;
        $data[self::FILTERS] = $this->filtersElements;
        $data[self::LISTS] = array();

        $this->layout()->setTemplate('ReportTool/layout');
        $this->layout()->setVariable("title", xlt("Encounter Report"));  // set tab title

        return $this->renderReport('reports_draw_table', $data, 'encounter-report', 'emergency-medicine/encounter-report/');
    }

    public function getDataAjaxAction()
    {
        $filters = array();
        $settings = $this->ajaxDefaultSettings();
        extract($settings);
        $dataToProcedure = $this->processFilters($filters);
        $columns[] = array(self::DATA => '');
        $columns[] = array(self::DATA => '');

        $result = $this->getData($dataToProcedure, $columns);

        foreach ($result['data'] as $key => $value) {
            // # in href causees refresh not to work
        }

        $result = json_encode($result);
        die($result);

    }

    public function excelAction()
    {
        $this->procedureName = 'EncounterReportExetended';
        $filters = array();
        $columns = array();
        $settings = $this->ExtendedReportSettings();
        extract($settings);
        $dataToProcedure = $this->processFilters($filters);

        $this->generateExcel($dataToProcedure, $columns, self::FILE_NAME, self::TAB_TITLE);
    }

    public function ExtendedReportSettings()
    {

        $filters = (array)json_decode($this->params()->fromQuery(self::FILTERS));
        $filters['offset'] = 0;
        $filters['limit'] = self::MAX_ROW_FOR_PDF;
        $filters['facility'] = implode(',', $filters['facility']);
        $columns = $this->buildExtendedColumns();

        $settings = array('filters' => $filters, 'columns' => $columns);

        return $settings;

    }

    public function pdfAction()
    {
        $filters = array();
        $columns = array();
        $settings = $this->pdfDefaultSettings();
        extract($settings);
        $reportName = self::REPORT_NAME;
        $dataToProcedure = $this->processFilters($filters);
        $this->createReportPdf($dataToProcedure, $columns, $reportName);

    }

    private function processFilters($filters)
    {
        $filters = $this->normalizedGenericFilters($filters);
        extract($filters);
        $currentUserId = $_SESSION['authUserID'];

        $branch_name = "'{$branch_name}'";
        $service_type = "'{$service_type}'";
        $hmo = "'{$hmo}'";

        $filtersToProcedure = array(
            $currentUserId,
            $branch_name,
            $service_type,
            $hmo,
            $from_date,
            $until_date,
            $offset,
            $limit,
        );
        return $filtersToProcedure;
    }

    public function CustomAjaxTemplateAction()
    {
        $result = array();
        //example
        //$result='{"results": [{"id": 1,"text": "Option 1"},{"id": 2,"text": "Option 2"}],"pagination": {"more": true}}';
        return $this->ajaxOutPut($result, 200, 'success');
    }

    public function serviceTypeListAjaxAction()
    {
        $result = array();

        if($_POST['branch_name']!=-1){
            $result = $this->getHealthcareServiceNames($_POST['branch_name']);
        }else{
            $result = $this->getValueSet($this->container, self::SERVICE_TYPES_SEARCH[0], self::SERVICE_TYPES_SEARCH);
        }

        if(count($result)!==1){
            $result[self::ALL_NUM] = xlt(self::ALL_STRING);
        }

        return $this->ajaxOutPut($result, 200, 'success');
    }


    private function buildExtendedColumns() {
        $columns = [];
        $extendedColumns = array(
          array('encounter_date', 'Encounter date'),
          array('first_name', 'First Name'),
          array('last_name', 'Last Name'),
          array('type_id', 'Id type'),
          array('id', 'SS'),
          array('insurance_body', 'HMO'),
          array('branch_name', 'Branch'),
          array('service_type', 'Service Type'),
          array('decision', 'Decision'),
          array('release_way', 'Evacuation way'),
          array('reason_titles', 'Reason for refferal'),
          array('doc_name', "Doctor's name"),
          array('doc_number', 'Doctor number'),
          array('payment_way', 'Payment method'),
          array('payment_amount', "Payment's amount"),
          array('reception_num', 'Receipt number'),
          array('birth_date', 'Patient Date Of Birth'),
          array('phone_cell', 'Patient phone'),
          array('city', 'City Name'),
          array('street', 'Street'),
          array('house_num', 'House number'),
          array('postal_code', 'Postal Code')
        );
        foreach ($extendedColumns as $item)
        {
            $columns[] = $this->addToColumns($item[0],$item[1]);
        }
        return $columns;
    }

    private function addToColumns($name, $title, $data = null) {
        return  array(
            'name' => $name,
            'data' => is_null($data) ? $name : $data,
            'title' => xl($title)
        );
    }

}
