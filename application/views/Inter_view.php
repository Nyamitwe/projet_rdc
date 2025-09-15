<!DOCTYPE html>
<html>
<head>
	<title></title>

	<style type="text/css">
		div {
			  margin: 15px;
			}
	</style>
</head>
<body>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<select id="country_select" onchange="loadsLanguage(this.value);">
</select>

<div>
  <span class="lang-text1"></span>
</div>
<div>
  <span class="lang-text2"></span>
</div>
<div>
  <span class="lang-text2"></span>/<span class="lang-text2"></span>
</div>

</body>

<script type="text/javascript">
	var LanguageList = {
  "EN" : "English",
  "ES" : "Español",
  "PT" : "Português",
  "FR" : "Francais"
};

//languages Objects
var WORDS_EN = {
  "text1" : "text One",
  "text2" : "text Two"
};

var WORDS_ES = {
  "text1" : "texto Un",
  "text2" : "texto Dos"
};

var WORDS_PT = {
  "text1" : "texto Um",
  "text2" : "texto Dois"
};

var WORDS_FR = {
  "text1" : "text Un",
  "text2" : "text deux"
};


window.onload = initialize;

function initialize() {
  var $dropdown = $("#country_select");    
  $.each(LanguageList, function(key, value) {
    $dropdown.
      append($("<option/>").
      val(key).
      text(value));
    });
    
  loadsLanguage("EN");
}

function loadsLanguage(lang){
  /*fills all the span tags with class=lang pattern*/ 
  $('span[class^="lang"]').each(function(){
    var LangVar = (this.className).replace('lang-','');
    var Text = window["WORDS_"+lang][LangVar];
    $(this).text(Text);        
  });
}
</script>
</html>