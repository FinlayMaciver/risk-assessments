{* Smarty *}
<html>
<head>
    <title>Risk Assessment - {$page_title}</title>
    <link type="text/css" rel="stylesheet" href="coshh.css" />
    {literal}
    <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="js/vf/libraries/validform.js"></script>
    <script type="text/javascript" src="js/localroutines.js"></script>
    <script type="text/javascript" src="js/jquery-validation-1.9.0/jquery.validate.min.js"></script>
    {/literal}
</head>
<body>
<div id="container">
    <div id="header">
        <h1>{if $admin}<a href="admin.php">{/if}Risk Assessment - {$page_title}{if $admin}</a>{/if}</h1>
    </div>
    <div id="maindiv">
        {include file=$sub_page}
    </div>
    <div id="footer">
        <p>Problems?  Email <a href="mailto:eng-itsupport@glasgow.ac.uk">eng-itsupport@glasgow.ac.uk</a></p>
    </div>
</div>
</body>
</html>
