<?php

/**
 * main class/lib functions for the COSHH DB
 *
 **/

class coshhDB
{
    var $m = null;
    var $db = null;
    var $collection = null;
    var $grid = null;
    var $db_host = "mongodb://localhost"; // is over-ridden depending on $GLOBALS['developmode'] below
    var $db_name = "coshh";
    var $db_collection = "coshh";
    var $db_opts = array();
    var $tpl = null;
    var $coshhadmin = 'Andrew.Glidle@glasgow.ac.uk';

    function __construct() {

        error_reporting (E_NOTICE);

        MongoLog::setModule( MongoLog::ALL );
        MongoLog::setLevel( MongoLog::ALL );

        try {
        //    $GLOBALS['developmode'] = 'production';
            if ($GLOBALS['developmode'] == "production") {
                 //$this->db_host = 'mongodb://coshhuser:ceeCh5Sh@west.eng.gla.ac.uk:27017,puppet.eng.gla.ac.uk:27017';
                 $this->db_host = 'mongodb://coshh2:hellokitty@polaroid.eng.gla.ac.uk,fuji.eng.gla.ac.uk/coshh2';
		 $this->db_opts = array("replicaSet" => "SOEreplica");
                 //$this->db_opts = array("replicaSet" => "assetSet");
            }
            else {
                 $this->db_host = "mongodb://127.0.0.1/coshh";
                 //$this->db_opts = array("persist" => "coshhpersist");
                 error_log("QQQQQQQQQQQQQQQQQQQQQQQQQQ");
            }
            $this->m = new MongoClient($this->db_host,$this->db_opts);
            $this->db = $this->m->coshh2;
            $this->collection = $this->db->coshh2;
            $this->grid = $this->db->getGridFS();
        } catch (Exception $e) {
            print "argh! $e";
            error_log("$e");
            error_log($this->db_host);
        }

        // initialise the Smarty engine
        $this->tpl = new personsDB_Smarty();
        $this->tpl->force_compile = true;
        $this->tpl->assign("risk_likely_opt",array("---","Improbable","Unlikely","Likely","Very Likely"));
        $this->tpl->assign("risk_severity_opt",array("---","Slight","Moderate","Very","Extremely"));
        $this->tpl->assign("haz_level_opt",array("---","Very toxic","Toxic","Harmful","Corrosive","Irritant"));
        $this->tpl->assign("haz_type_opt",array("---","Carcinogen", "MEL, OEL", "Dust", "Nanoparticle", "Micro-organism","Flammable","Reproductive","Teratogen"));
        $this->tpl->assign("haz_quant_val",array("---","Small","Moderate","Large","Very Large"));
        $this->tpl->assign("haz_quant_out",array("---","Small &lt; 10mg","Moderate 10mg - 10g","Large 10g - 100g","Very Large &gt; 100g"));
        $this->tpl->assign("haz_route_opt",array("---","Inhalation","Ingestion","Skin absorption","Eye/Skin contact","Injection"));
        $this->tpl->assign("haz_exposure_opt",array("---","Serious", "Not serious", "Not known"));
        $this->tpl->assign("equip_opt",array("Eye Protection","Face Protection", "Hand Protection", "Foot Protection", "Respiratory Protection"));
        $this->tpl->assign("supervision_val",array("straightforward","specific","personal"));
        $this->tpl->assign("supervision_out",array("Supervisor approves straightforward and routine work","Supervisor will specifically approve the scheme of work outlined above","Supervisor will provide personal supervision to control and oversee the work"));
        $this->tpl->assign("monitor_val",array("airborne","biological"));
        $this->tpl->assign("monitor_out",array("Monitoring of airborne contaminents will be required","Biological monitoring of workers will be required"));
        $this->tpl->assign("written_out",array("Written emergency instructions will be provided for workers and others on the site who might be affected"));
        $this->tpl->assign("written_val",array("yes"));
        $this->tpl->assign("emergency_val",array("spill neutralisation","eye irrigation point","body shower","other first aid provisions","breathing apperatus","external emergency services","poison antidote"));
        $this->tpl->assign("emergency_out",array("Spill neutralisation chemicals", "Eye irrigation point", "Body Shower", "Other first aid provisions","Breathing apparatus (with trained operator)","External Emergency Services","Poison Antidote"));
        $this->tpl->assign("inform_val",array("acstaffstudent","cleaners","contractors","other"));
        $this->tpl->assign("inform_out",array("Academic/Postgraduate staff, research &amp; undergraduate students and technicians working in the lab","Cleaners","Contractors","Other"));
        $this->tpl->assign("persontype_val",array("student","staff"));
        $this->tpl->assign("persontype_out",array("Student","Staff"));
        $this->tpl->assign("bio_cat_opt",array("----","ACDP Class 1","ACDP Class 2", "ACDP Class 3", "ACDP Class 4"));
        $this->tpl->assign("bio_risk_opt",array("----","Low","Medium","High"));
        $this->tpl->assign("bio_route_a_opt",array("---","Inhalation","Ingestion","Skin absorption"));
        $this->tpl->assign("bio_route_b_opt",array("---","Eye/skin contact","Injection"));
    }

    function updateItem($item)
    {
        if (!array_key_exists("_id",$item)) {
            $item = $this->addItem($item);
        }
        else {
            $this->collection->update(array("_id" => $item['_id']),$item);
        }

        return $item;
    }

    function addItem($item)
    {
        $this->collection->insert($item);
        return $item;
    }


    function showIndex()
    {
        // default index page/action
        $this->tpl->assign("page_title","Home");
        $this->tpl->assign("sub_page","default.tpl");
        $this->tpl->display("index.tpl");
        return true;
    }


    function submitForm()
    {
        // handle a new form submission

        error_log("############################################");
        // create our assoc array to dump into the DB
        $form = array();

        // check if we have a uuid field - if so we are editing an existing form so fetch from the db
        if (array_key_exists('uuid',$_POST)) {
            $form = $this->findItem("uuid",$_POST['uuid']);
            if (!is_array($form)) {
                error_log("COSHH - failed to find a form during an edit session - " . $_POST['uuid']);
                print "Error finding form";
                exit();
            }
        }
        else {
            // create all the fields we manually need
            $form['ItemType'] = "coshhForm";
            $form['SubType'] = $_POST['formtype'];
            $form['UploadDate'] = new MongoDate();
            $form['uuid'] = md5($_POST['title'] . mt_rand());
            $form['Files'] = array();
            if (array_key_exists('multiuser',$_POST)) {
                $form['MultiUser'] = true;
                $form['Users'] = array();
            } else {
                $form['MultiUser'] = false;
            }
        }
        if (!$form["MultiUser"] or !array_key_exists("multiemail", $_POST)) {
            // only update the form fields if the form is *not* a multi-user with a submitted new email
            // address.  Otherwise users can over-write multi-user forms... (I hate the way this was
            // done - it's caused so many problems... sigh)
            $form['data'] = $_POST;
        }

        // check that any email addresses look half sane
/*        if (array_key_exists('multiuser', $_POST)) {
            // we first check if this is a multi-user form.  if so, copy the labguardian email address to the
            // other two fields (makes sure it displays properly on the formlist())
            $form['data']["supervisor"] = $form['data']['labguardian'];
            $form['data']["personemail"] = $form['data']['labguardian'];
        }
*/
        foreach(array("personemail","supervisor","labguardian") as $addr) {
            if (array_key_exists($addr,$form['data'])) {
                if (! preg_match("/[a-z0-9].+\@/i",$form['data'][$addr])) {     // ie, one or more alphanumeric followed by an @
                    $form['data'][$addr] = "INVALID - " . $form['data'][$addr];
                }
                if (substr_count($form['data'][$addr],'@') > 1) {           // ie, more than one @ in the address - dodgy
                    $form['data'][$addr] = "INVALID - " . $form['data'][$addr];
                }
            }
        }
        if (array_key_exists('multiuser', $_POST)) {
            if (preg_match('/\@/',$_POST['multiemail'])) {
                if (!array_key_exists('Users', $form)) {
                    $form['Users'] = array();
                    error_log("ZZZZZZZZZZZZZZZZZZZ created Users[]");
                }
                $form['Users'][] = $_POST['multiemail'] . '::' . time();
                error_log("ZZZZZZZZZZZZZZZZZZZ added to Users[] : " . $_POST['multiemail']);
            } else {
                error_log("Invalid multiemail");
            }
        } else {
            error_log("Not multiuser");
        }

        // check that we have a title set
        if (! preg_match("/[a-z0-9]/i",$form['data']['title'])) {
            $form['data']['title'] = "No title supplied";
        }

        // we always want to set these fields whether new or editing
        $form['LastUpdated'] = new MongoDate();
        $form['SearchDump'] = print_r($form,true);      // dump the whole object as a string to make searching easy(read: lazy git)
        $form['SearchDump'] = str_replace("\n","",$form['SearchDump']);
        if (!$form['Status']) {
            // set the status to Pending if we don't already have the status set - this (hopefully!) catches
            // people submitting multi-user forms so that each person that adds their names doesn't reset the
            // form to "Pending" again.
            $form['Status'] = "Pending";
        }

        // process any file uploads
        for($i = 1; $i < 10; $i++) {
            $fname = "Filedata$i";
            if (array_key_exists($fname,$_FILES)) {
                $name = $_FILES[$fname]['name'];        // Get Uploaded file name
                $type = $_FILES[$fname]['type'];        // Try to get file extension

                if (preg_match("/[a-z0-9]/i",$name)) {
                // upload the file to Mongo's "gridFS"
                    try {
                        $fileid = $this->grid->storeUpload($fname, array("metadata" => array("filename" => $name, "ContentType" => $type, "FormUUID" => $form['uuid'])));
                        $fileid = $fileid->{'$id'};
                        $form['Files'][] = $fileid;     // add the file id to the $form data
                    }
                    catch (Exception $e) {
                        print "Failed to upload files! :-(";
                        error_log("COSHH Upload files failed : " . $e->getMessage() . " # $name # $type # $fname");
                        exit();
                    }
                }
            }
        }

        $this->updateItem($form);
        if (! array_key_exists("godmode",$_POST)) {     // only send emails if we are not in 'godmode' (ie, admin re-edits)
            $this->sendAlert($form['data']['supervisor'],"COSHH Form approval required",$form['uuid'],"supervisor");
            $this->sendAlert($form['data']['labguardian'],"COSHH Form approval required",$form['uuid'],"guardian");
            $this->sendAlert($this->coshhadmin,"COSHH Form approval required",$form['uuid'],"coshhadmin");
        }
        $this->tpl->assign("page_title","Thank you");
        $this->tpl->assign("message","Thank you - form submitted");
        $this->tpl->assign("sub_page","thankyou.tpl");
        $this->tpl->display("index.tpl");
        return true;

    }

    public function submitJwnc()
    {
        $formtype = $_POST['formtype'];
        $email = $_POST['email-address'];
        $form = $this->findItem("JwncType",$formtype);
        if (!$form) {
            $form['ItemType'] = "jwncForm";
            $form['JwncType'] = $formtype;
            $form['Users'] = array();
        }
        $form['Users'][] = $email;
        $form['LastUpdated'] = new MongoDate();
        $this->updateItem($form);
        $this->tpl->assign("page_title","Thank you");
        $this->tpl->assign("message","Thank you - form submitted");
        $this->tpl->assign("sub_page","thankyou.tpl");
        $this->tpl->display("index.tpl");
        return true;
    }

    function resendAlerts($uuid)
    {
        $form = $this->findItem("uuid",$uuid);
        if (!is_array($form)) {
            return false;
        }
        $this->sendAlert($form['data']['supervisor'],"COSHH Form approval required",$form['uuid'],"supervisor");
        $this->sendAlert($form['data']['labguardian'],"COSHH Form approval required",$form['uuid'],"guardian");
        $this->sendAlert($this->coshhadmin,"COSHH Form approval required",$form['uuid'],"coshhadmin");
        return true;
    }

    function sendAlert($to,$subject,$uuid,$mode)
    {
        // function to send an email out

        // bail out if email address begins with "INVALID" (see validation in submitForm()) or is empty
        if (preg_match("/^INVALID/",$to) or !preg_match("/[a-z0-9]/i",$to)) {
            return false;
        }
        else {
            switch($mode) {     // set the url param to match the appropriate person type
                case "supervisor" : $p = "id"; break;
                case "guardian"   : $p = "gid"; break;
                case "coshhadmin" : $p = "aid"; break;
                default           : error_log("COSHH : sendAlert with no valid mode"); return false;
            }
            $headers = "From: School of Engineering Risk Assessment <donotreply@glasgow.ac.uk>";
            $body = "This is an automated message to let you know a new COSHH form\n" .
                    "has been submitted and your approval is required.  Please visit :\n" .
                    "\n" .
                    "http://" . $_SERVER['SERVER_NAME'] . "/tools/risk/approve.php?$p=$uuid\n" .
                    "\n";
            mail($to,$subject,$body,$headers);
            return true;
        }
    }



    function showForm($type = 'general')
    {
        // show a new coshh form - $type is the type of form to show

        // check what type of form we want
        switch($type) {
            case "general":
                $title = "General";
                $form = "coshh_general.tpl";
                break;
            case "chemical":
                $title = "Chemical";
                $form = "coshh_chemical.tpl";
                break;
            case "bio":
                $title = "Biological";
                $form = "coshh_bio.tpl";
                break;
            case "jwnc":
                $title = "JWNC";
                $form = "jwnc_test.tpl";
                break;
            default:
                exit;
        }

        if (array_key_exists('multiuser', $_GET)) {
            $this->tpl->assign("multiuser",true);
        } else {
            $this->tpl->assign("multiuser",false);
        }
        $this->tpl->assign("page_title",$title);
        $this->tpl->assign("form",$form);
        $this->tpl->assign("sub_page","show_form.tpl");
        $this->tpl->display("index.tpl");
        return true;
    }


    function showFormApproval($uuid,$returnstring = false,$mode = "")
    {
        // function to show a pending form to be approved. if $returnstring then returns the template as a string instead of displaying it
        // $mode is set to match the type of person who is viewing the form (supervisor, admin, guardian, guest)
        $form = $this->findItem("uuid",$uuid);
        if (!is_array($form)) {
            return false;
        }

        // parse any files attached to the form
        $files = array();
        $cursor = $this->grid->find(array("metadata.FormUUID" => $form['uuid']));
        if ($cursor) {
            foreach($cursor as $f) {
                $files[] = array( "id" => $f->file['_id'], "filename" => $f->file['metadata']['filename'] );
            }
        }
        if (array_key_exists('Users', $form)) {
            $newlist = array();
            foreach($form['Users'] as $u) {
                list($email,$timestamp) = preg_split("/::/",$u);
                $newlist[] = '<a href="mailto:' . $email . '">' . $email . '</a> @ ' . date("d/m/Y H:i",$timestamp);
            }
            $form['Users'] = $newlist;
        }

        $this->tpl->assign("mode",$mode);
        $this->tpl->assign("data",$form['data']);
        $this->tpl->assign("formdata",$form);
        $this->tpl->assign("files",$files);
        if ($mode != "guest") {
            $this->tpl->assign("forapproval",true);
            $this->tpl->assign("page_title","Approval");
        }
        else {
            $this->tpl->assign("page_title","View form");
        }

        switch ($form['data']['formtype']) {
            case "chemical": $f = "coshh_chemical.tpl"; break;
            case "biological": $f = "coshh_bio.tpl"; break;
            case "general": $f = "coshh_general.tpl"; break;
            default: $f = "coshh_general.tpl"; break;
        }

        $this->tpl->assign("form",$f);
        $this->tpl->assign("sub_page","show_form.tpl");
        if ($returnstring) {
            $template = $this->tpl->fetch("index.tpl");
            return $template;
        }
        else {
            $this->tpl->display("index.tpl");
            return true;
        }
    }


    function setFormStatus($uuid,$status,$mode = "")
    {
        // function to set a forms status (ie, approve, reject)
        $form = $this->findItem("uuid",$uuid);
        if (! is_array($form)) {
            return false;
        }

        switch ($mode) {
            case "supervisor" : $field = "StatusSupervisor"; break;
            case "guardian"   : $field = "StatusGuardian"; break;
            case "coshhadmin" : $field = "Status"; break;
            default : error_log('COSHH - switch $mode in setFormStatus has no valid $mode'); print "Error - missing mode!"; exit(); break;
        }
        $form[$field] = $status;
        $form['LastUpdated'] = new MongoDate();
        $this->updateItem($form);

        $this->tpl->assign("page_title","Thank you");
        $this->tpl->assign("message","Thank you - form marked as $status");
        $this->tpl->assign("sub_page","thankyou.tpl");
        $this->tpl->display("index.tpl");

        // if the form was rejected, send an email back to the originator
        if (preg_match("/rejected/i",$status)) {
            $body = "Your risk form was rejected - reason given below.  To correct & re-submit visit\n\n" .
                    "http://" . $_SERVER['SERVER_NAME'] . "/tools/risk/index.php?id=" . $form['uuid'] . "\n" .
                    "\n\n" .
                    '"' . $_POST['ap_reason'] . '"' . "\n";
            $to = $form['data']['personemail'];
            $subject = "Risk Assessment Form - rejected";
            $bcc = "Bcc: " . $this->coshhadmin;
            if (! preg_match("/^INVALID/",$form['data']['supervisor'])) {     // see validation code in sendForm()
                $bcc = $bcc . ", " . $form['data']['supervisor'];
            }
            if (! preg_match("/^INVALID/",$form['data']['labguardian'])) {     // see validation code in sendForm()
                $bcc = $bcc . ", " . $form['data']['labguardian'];
            }
            $bcc = $bcc . "\r\n";
            if (! preg_match("/^INVALID/",$to)) {     // see validation code in sendForm()
                mail($to,$subject,$body,$bcc);
            }
            //mail($this->coshhadmin,"COSHH Form rejected",$body);
        }
        else {
            $body = "Your risk assessment form was approved by ";
            switch ($mode) {
                case "supervisor" : $blurb = "your supervisor."; break;
                case "guardian"   : $blurb = "the lab guardian."; break;
                case "coshhadmin" : $blurb = "the school safety officer."; break;
                default : $blurb = "a mysterious figure, cloaked in black, their identity forever a secret."; break;
            }
            $body = $body . $blurb . "\n\n" . '"' . $form['data']['title'] . "\"\n\n";
            $to = $form['data']['personemail'];
            $subject = "Risk Assessment Form - approved";
            if (! preg_match("/^INVALID/",$to)) {     // see validation code in sendForm()
                mail($to,$subject,$body);
            }
            $body = "A risk form has been approved. To correct & re-submit visit\n\n" .
                    "http://" . $_SERVER['SERVER_NAME'] . "/tools/risk/admin.php?id=" . $form['uuid'] . "\n" .
                    "\n\n";
            mail($this->coshhadmin, $subject, $body);
        }

        return true;
    }


    function findItem($field,$value)
    {
        // function to search for an item
        $cursor = $this->collection->findOne(array($field => $value));
        return $cursor;
    }


    function removeItem($uuid)
    {
        // remove a form from the collection
        $this->collection->remove(array("uuid" => $uuid),array("justOne" => true));
        return true;
    }


    function showFormList($sortfield = "LastUpdated", $onlyStudents = false)
    {
        // function to list all of the forms - sorted by $sortfield

        if (array_key_exists("sf",$_GET)) {
            $sortfield = $_GET['sf'];
        }
        if (array_key_exists("onlystudents", $_GET)) {
            $onlyStudents = true;
        }

        $cursor = $this->collection->find(array("ItemType" => "coshhForm"));
        $cursor->sort(array($sortfield=>-1));
        $forms = array();
	error_log("COSHHHHHHH");
        if ($cursor) {
            $i = 0;
            foreach ($cursor as $line) {
                // if we are only showing students and their email isn't an obvious undergrad one then skip
                if ($onlyStudents && strpos($line['data']['personemail'], 'student.gla.ac.uk') === false) {
                    continue;
                }
                $forms[$i++] = array (
                            "SubType" => $line['SubType'],
                            "UploadDate" => $line['UploadDate']->sec,
                            "LastUpdated" => $line['LastUpdated']->sec,
                            "Status" => $line['Status'],
                            "Title" => $line['data']['title'],
                            "Location" => $line['data']['location'],
                            "uuid" => $line['uuid'],
                            "SubmittedBy" => $line['data']['personemail']
                        );
            }
        }
        $old_forms = $this->searchOldForms("");
        foreach($old_forms as $form) {
            $forms[$i++] = $form;
        }

        $this->tpl->assign("forms",$forms);
        $this->tpl->assign("sub_page","form_list.tpl");
        $this->tpl->display("index.tpl");
        return true;
    }

    function showMultiFormList($sortfield = "LastUpdated")
    {
        // function to list all of the multi-user forms - sorted by $sortfield

        if (array_key_exists("sf",$_GET)) {
            $sortfield = $_GET['sf'];
        }
        $cursor = $this->collection->find(array("ItemType" => "coshhForm","MultiUser" => true));
        $cursor->sort(array($sortfield=>-1));
        $forms = array();
    error_log("MULTIUSER");
        if ($cursor) {
            $i = 0;
            foreach ($cursor as $line) {
                $forms[$i++] = array (
                            "SubType" => $line['SubType'],
                            "UploadDate" => $line['UploadDate']->sec,
                            "LastUpdated" => $line['LastUpdated']->sec,
                            "Status" => $line['Status'],
                            "Title" => $line['data']['title'],
                            "Location" => $line['data']['location'],
                            "uuid" => $line['uuid'],
                            "SubmittedBy" => $line['data']['personemail']
                        );
            }
        }
        $this->tpl->assign("multiuser",true);
        $this->tpl->assign("forms",$forms);
        $this->tpl->assign("sub_page","form_list.tpl");
        $this->tpl->display("index.tpl");
        return true;
    }

    function searchForms($term,$field = "")
    {
        //function to search forms for a given $term.  If $field is empty all(ish) fields are searched.

        if ($field != "any") {
            // we have a fieldname
            $regex_term = new MongoRegex("/$term/i");       // ie, case-insensitive match "*thing*"
            //$cursor = $this->collection->find(array($field,$regex_term));
            $cursor = $this->collection->find(array($field => $regex_term));
        }
        else {
            $regex_term = new MongoRegex("/$term/i");       // ie, case-insensitive match "*thing*"
            $cursor = $this->collection->find(array('$or' => array(
                            array('Status' => $regex_term),
                            array('SearchDump' => $regex_term),
                        )));
        }

        $forms = array();
        if ($cursor) {
            $i = 0;
            foreach ($cursor as $line) {
                $forms[$i++] = array (
                            "SubType" => $line['SubType'],
                            "UploadDate" => $line['UploadDate']->sec,
                            "LastUpdated" => $line['LastUpdated']->sec,
                            "Status" => $line['Status'],
                            "Title" => $line['data']['title'],
                            "Location" => $line['data']['location'],
                            "uuid" => $line['uuid'],
                            "SubmittedBy" => $line['data']['personemail']
                        );
            }
        }
        $old_forms = $this->searchOldForms($term);
        foreach($old_forms as $form) {
            $forms[$i++] = $form;
        }
        $this->tpl->assign("forms",$forms);
        $this->tpl->assign("sub_page","form_list.tpl");
        $this->tpl->display("index.tpl");
        return true;
    }


    public function searchOldForms($term)
    {
        $matches = array();
        $filenames = glob("old-forms/*.htm");
        foreach ($filenames as $file) {
            $match = $this->fileContains($file, $term);
            if ($match) {
                $matches[] = $match;
            }
        }
        return $matches;
    }

    public function fileContains($filename, $term)
    {
        $contents = file_get_contents($filename);
        if (preg_match("/$term/i", $contents)) {
            preg_match('/name="title".+?value="([^"]+)" /', $contents, $matches);
            $title = $matches[1];
            preg_match('/name="location".+?value="([^"]+)" /', $contents, $matches);
            $location = $matches[1];
            $location = preg_replace("/([\-\/])/", "$1 ", $location);
            return array (
                "SubType" => "Old",
                "UploadDate" => strtotime('22-09-2010'),
                "LastUpdated" => strtotime('22-09-2010'),
                "Status" => "Approved",
                "Title" => $title,
                "Location" => $location,
                "uuid" => $filename,
                "SubmittedBy" => "N/A"
            );
        }
        return false;
    }

    function sendFile($id)
    {
        // function to stream an attached file back to the browser

        $file = $this->grid->findOne(array("_id" => new MongoID($id)));
        if (!$file) {
            error_log("COSHH - could not find file $id");
            exit();
        }
        $name = $file->file["metadata"]["filename"];
        $type = $file->file["metadata"]["ContentType"];
        header('Content-Type:' . $type);
        header('Content-Disposition: attachment; filename=' . $name);
        header('Content-Transfer-Encoding: binary');
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: public");
        echo $file->getBytes();
        return true;
    }


    function sendPdf($uuid)
    {
        // function to stream a form as a pdf
        require_once("dompdf/dompdf_config.inc.php");
        $this->tpl->assign("pdf",true);
        $html = $this->showFormApproval($uuid,true);
        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
        $dompdf->render();
        $dompdf->stream("coshh-form-$uuid.pdf");
    }

    function editForm($uuid)
    {
        // function to edit a form (from a submitter point of view)
        // we end up here if the form was rejected

        $form = $this->findItem("uuid",$uuid);
        if (! is_array($form)) {
            return false;
        }

        // parse any files attached to the form
        $files = array();
        $cursor = $this->grid->find(array("metadata.FormUUID" => $form['uuid']));
        if ($cursor) {
            foreach($cursor as $f) {
                $files[] = array( "id" => $f->file['_id'], "filename" => $f->file['metadata']['filename'] );
            }
        }
        $this->tpl->assign("page_title","Resubmit");
        $this->tpl->assign("data",$form['data']);
        $this->tpl->assign("formdata",$form);
        $this->tpl->assign("files",$files);
        $this->tpl->assign("foredit",true);
        if (array_key_exists("godmode",$_GET)) {
            $this->tpl->assign("godmode",true);
        }
        else {
            $this->tpl->assign("godmode",false);
        }
        switch ($form['data']['formtype']) {
            case "chemical": $f = "coshh_chemical.tpl"; break;
            case "biological": $f = "coshh_bio.tpl"; break;
            case "general": $f = "coshh_general.tpl"; break;
            default: $f = "coshh_general.tpl"; break;
        }
        $this->tpl->assign("form",$f);
        $this->tpl->assign("sub_page","show_form.tpl");
        $this->tpl->display("index.tpl");
        return true;
    }

    public function showJwnc($formtype = "jwnc_test1")
    {

        $form = $this->findItem("JwncType",$formtype);
        if (!$form) {
            $form['Users'] = array();
        }
        $this->tpl->assign("users",array_reverse($form['Users']));
        $this->tpl->assign("formtype",$formtype);
        $this->tpl->display($formtype . ".tpl");
        return true;
    }

    public function exportAllAsPdf()
    {
        $cursor = $this->collection->find(array("ItemType" => "coshhForm"));
        $forms = array();
        if ($cursor) {
            $i = 0;
            foreach ($cursor as $line) {
                $forms[$i++] = array (
                            "UploadDate" => $line['UploadDate']->sec,
                            "Title" => $line['data']['title'],
                            "uuid" => $line['uuid'],
                        );
            }
        }
        foreach($forms as $form) {
            print $form['uuid'] . '######' . preg_replace("/[^a-zA-Z0-9]+/","_",$form['Title'] . '_' . $form['UploadDate']) . ".pdf\n";
        }
    }
}
?>
