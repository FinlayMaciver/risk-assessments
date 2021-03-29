<?php

// Create the initial form object
$formObj = new ValidForm("coshhForm","Required fields are marked in bold");

// begin adding fields
$formObj->addField("tasktitle", "Task/Activity Title", VFORM_STRING,
      array(
          "maxLength" => 255,
          "required" => TRUE
      ),
      array(
          "maxLength" => "Your input is too long. A maximum of %s characters is OK.",
          "required" => "This field is required.",
          "type" => "Enter only letters and spaces."
      )
  );

$formObj->addField("location", "Location(s) where work will be carried out", VFORM_STRING,
      array(
          "maxLength" => 1024,
          "required" => TRUE
      ),
      array(
          "maxLength" => "Your input is too long. A maximum of %s characters is OK.",
          "required" => "This field is required.",
          "type" => "Enter only letters and spaces."
      )
  );

$formObj->addField("shortdesc", "Short description of procedures involved in the Activity", VFORM_TEXT,
      array(
          "maxLength" => 2048,
          "required" => TRUE
      ),
      array(
          "maxLength" => "Your input is too long. A maximum of %s characters is OK.",
          "required" => "This field is required.",
          "type" => "Enter only letters and spaces."
      )
  );

$
