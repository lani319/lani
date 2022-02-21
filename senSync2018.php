<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>  <!--뷰포트 설정 -->	
<link href="senSync.css" rel="stylesheet" type="text/css"/>	
 <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=PT+Sans:700' rel='stylesheet' type='text/css'>	
</head>
<body>
<form name="frmMain" target="invframe" method="post" action="senSync2018ok.php">
<table class="type03">
<tr>
<th scope="row" colspan="3">
서울경제TV SENPLUS 아이디를 입력해 주세요.
</th>
</tr>
<tr>
<td>
<div class="textbox">
  <label for="ex_input">SENPLUS 아이디</label>
  <input type="text" id="ex_input" name="txtUserId">
  <!--
  <input type="submit" value="조회" tabindex="3">
  -->
</div>
<br>
<div class="row">
        <div class="col three">             
            <a href="#" onclick="submitForm();" class="btn btn-concrete">확 인</a>
		</div>
</div>
<!--
아이디 : <input type="text" name="txtUserId" size="20" tabindex="1">
-->
 
</td>
</tr>
</table>
</form>
</body>
<script type="text/javascript">
function submitForm(){
		document.frmMain.submit();
		
	}

</script>


<iframe name="invframe"  width="100%" height="100%" frameborder=0>

</iframe>









