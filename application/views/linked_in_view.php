<html>
<head>
<title>Connections App Example</title>
 
<script type="text/javascript" src="http://platform.linkedin.com/in.js">
  api_key: 24kp3woxkhce
  authorize: true
</script>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link media="all" type="text/css" href="http://developer.linkedinlabs.com/tutorials/css/jqueryui.css" rel="stylesheet"/>
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.5b1.js"></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/jquery-ui.min.js"></script> 
 
<script type="text/javascript">
 
function loadData() {
  IN.API.Connections("me")
    .fields(["pictureUrl","publicProfileUrl"])
    .params({"count":30})
    .result(function(result) {
      profHTML = "";
      for (var index in result.values) {
          profile = result.values[index]
          if (profile.pictureUrl) {
              profHTML += "<p><a href=\"" + profile.publicProfileUrl + "\">";
              profHTML += "<img class=img_border height=30 align=\"left\" src=\"" + profile.pictureUrl + "\"></a>";   
          }    
      }
      $("#connections").html(profHTML);
    });
}
 
 
</script>
 
 
</head>
<body class="yui3-skin-sam  yui-skin-sam">
<div id="connections">Hello
    </div>
    <script type="IN/Login" data-onAuth="loadData"></script>
</body>
</html>