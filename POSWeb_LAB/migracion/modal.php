<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery UI Dialog - Default functionality</title>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
  <script>
  $(function() {
  
  });

  function js_abrir_cal()
    {
        $( "#dialog" ).dialog();
    }
  </script>
</head>
<body>
 
<div id="dialog" title="Basic dialog" style="display:none">
  <p>This is the default dialog which is useful for displaying information. The dialog window can be moved, resized and closed with the 'x' icon.</p>
</div>
 
 <div onclick="js_abrir_cal()">abriir</div>
</body>
</html>