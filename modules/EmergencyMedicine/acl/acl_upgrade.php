<?php
// Ensure this script is not called separately
if ((empty($_SESSION['acl_setup_unique_id'])) ||
    (empty($unique_id)) ||
    ($unique_id != $_SESSION['acl_setup_unique_id'])) {
    die('Authentication Error');
}
unset($_SESSION['acl_setup_unique_id']);

use OpenEMR\Common\Acl\AclExtended;

return $ACL_UPGRADE = array(

    '0.1.0' => function () {



        //AclExtended::addNewACL('Imaging Technician', 'imaging_technician', 'write', 'Things that imaging technician can modify');

        $admin_write  = AclExtended::getAclIdNumber('Administrators', 'write');

//        $imaging_technician_view  = AclExtended::getAclIdNumber('Imaging Technician', 'view');



        //using BY https://matrixil.sharepoint.com/:x:/r/sites/DTG/Clinical/_layouts/15/Doc.aspx?sourcedoc=%7B49114388-8709-407B-BF08-8E8F26C8119F%7D&file=%D7%A7%D7%9C%D7%99%D7%A0%D7%99%D7%A7%D7%9C%20%D7%93%D7%99%D7%9E%D7%95%D7%AA%20-%20%D7%94%D7%A8%D7%A9%D7%90%D7%95%D7%AA%20%D7%9C%D7%A4%D7%99%20%D7%AA%D7%A4%D7%A7%D7%99%D7%93%D7%99%D7%9D%20%D7%92%D7%A8%D7%A1%D7%94%201.xlsx&action=default&mobileredirect=true&cid=6559357a-ef09-499a-b410-0a6b0078e2e7
        //OBJECT OF ACL
        //AclExtended::addObjectSectionAcl('client_app', 'Client Application');
       // AclExtended::addObjectAcl('client_app', 'Client Application', 'PatientTrackingInvited','Patient Tracking Invited');

    }
);

