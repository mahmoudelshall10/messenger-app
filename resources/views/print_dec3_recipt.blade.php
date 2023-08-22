<!DOCTYPE html>
<html lang="en-US" dir="rtl">

<head>
    <meta charset="-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" href="http://localhost/turbo_erp/website_design\themes\images\logo.png" type="image/gif" sizes="64x64">

<style>
#customers {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid black;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #f2f2f2;
  color: black;
}
</style>




	<!--Less styles -->
	   <!-- Other Less css file //different less files has different color scheam
		<link rel="stylesheet/less" type="text/css" href="themes/less/simplex.less">
		<link rel="stylesheet/less" type="text/css" href="themes/less/classified.less">
		<link rel="stylesheet/less" type="text/css" href="themes/less/amelia.less">  MOVE DOWN TO activate
		-->
		<!--<link rel="stylesheet/less" type="text/css" href="themes/less/bootshop.less">
		<script src="themes/js/less.js" type="text/javascript"></script> -->

	<!-- Bootstrap style -->

		    <link id="callCss" rel="stylesheet" href="http://localhost/turbo_erp/website_design/themes/bootshop/bootstrap.min.css" media="screen"/>
	    <link href="http://localhost/turbo_erp/website_design/themes/css/base.css" rel="stylesheet" media="screen"/>



	<!-- Bootstrap style responsive -->
		<link href="http://localhost/turbo_erp/website_design/themes/css/bootstrap-responsive.min.css" rel="stylesheet"/>
		<link href="http://localhost/turbo_erp/website_design/themes/css/font-awesome.css" rel="stylesheet" type="text/css">
	<!-- Google-code-prettify -->
		<link href="http://localhost/turbo_erp/website_design/themes/js/google-code-prettify/prettify.css" rel="stylesheet"/>
	<!-- fav and touch icons -->
	    <link rel="shortcut icon" href="themes/images/ico/favicon.ico">
	    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="themes/images/ico/apple-touch-icon-144-precomposed.png">
	    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="themes/images/ico/apple-touch-icon-114-precomposed.png">
	    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="themes/images/ico/apple-touch-icon-72-precomposed.png">
	    <link rel="apple-touch-icon-precomposed" href="themes/images/ico/apple-touch-icon-57-precomposed.png">
		<style type="text/css" id="enject"></style>


  </head>



<body onload="window.print()">

<div class="span9">


	<meta name="csrf-token" content="{{ csrf_token() }}">
<br class="clr"/>
<div class="tab-content">
	<header  style="margin-left: 5%;margin-right: 5%;">

			<div style="float:left;margin-right: 20%">
			<img src="{{url('storage/app')}}/{{ $objACON1_SETUP->pic_php }}"  id="blah4" width="150" height="100">
		   </div>
		   <center>

		   	<div style="float:left;font-size:20px;font-weight: bold; width: 150px;border: 5px solid grey;padding: 2px;margin: 2px;text-align: center;margin-right: 10%;margin-top: 4%;background-color: grey;">
			<b>{{ @$objdec3->name1 }}</b><br>
			<b> رقم المستند {{ @$objdec3->no_1 }}</b>
			</div>
		   </center>



  </header>



	<table id="customers" dir="rtl" style="width: 90%;margin-left:5%;margin-right:5%">
	    <thead>
	    	     <tr>
	          <td><b> التاريخ</b></td>
	          <td><b>{{ date('Y-m-d',strtotime(@$objdec3->date_1)) }}</b></td>


					</tr>
					<tr>
	        <td ><b>الشرح</b></td>
	        <td colspan="2"><b>
	        @foreach($arracon as $objBarcode)
	        @if($objBarcode->i_price != 0)
	        	{{ @$objBarcode->ff }}
	        	@if(count($arracon) > 2)
	        	/
	       	 @endif
	        @endif
	        @endforeach
	        </b></td>
			</tr>






	      </thead>
          <tbody>

		  </tbody>
    </table>

   </br>
  <table id="customers" dir="rtl" style="width: 90%;margin-left:5%;margin-right:5%">
	    <thead>


	          <tr>

	          <td><b>اسم العميل</b></td>
	          <td colspan="2"><b>
              @if(@$objdec3->code1 == 6)
	        @foreach($arracon as $objBarcode)
	        @if($objBarcode->i_price1 != 0)
	        	{{ @$objBarcode->i_item }}
	        	@if(count($arracon) > 2)
	        	/
	       	 @endif
	        @endif
	        @endforeach
            @elseif(@$objdec3->code1 == 7)
            @foreach($arracon as $objBarcode)
	        @if($objBarcode->i_price != 0)
	        	{{ @$objBarcode->i_item }}
	        	@if(count($arracon) > 2)
	        	/
	       	 @endif
	        @endif
	        @endforeach
            @endif
	        </b></td>

			</tr>
	      </thead>
	      <tbody>


	          <tr>

	          <td><b>المبلغ </b></td>
	          <td><b>{{$objdec3->tot1 }}</b></td>

			</tr>
	      </tbody>
	      <tr>
           <td style="font-size:30px;text-align:center" colspan="2">{{ @$objdec3->name6 }}</td>
	      </tr>

    </table>

    <br>



		<br></br>
	 <table class="table table-bordered" style="width: 90%;margin-left:5%;margin-right:5%;direction: rtl;">
	    <thead>

	        <tr>

			 <!--   <td style="margin-left:100px;"> {{$objACON1_SETUP->sen2}}</td>

			   <td style="margin-left:100px;"> {{$objACON1_SETUP->sen3}}</td> -->

			    <td style="margin-left:100px;">محاسب</td>
			    <td style="margin-left:100px;">مراجعة</td>
			     <td style="margin-left:100px;">اعتماد</td>




			</tr>



	      </thead>
          <tbody>

		  </tbody>
    </table>
    <br>
	<!-- <br></br>
	 <table class="table table-bordered" style="width: 90%;margin-left:5%;margin-right:5%">
	    <thead>

	        <tr>
	          <td >  {{$objACON1_SETUP->sen1}}</td>

			   <td style="margin-left:100px;"> {{$objACON1_SETUP->sen2}}</td>

			   <td style="margin-left:100px;"> {{$objACON1_SETUP->sen3}}</td>

			    <td style="margin-left:100px;"> توقيع المستلم </td>

			</tr>



	      </thead>
          <tbody>

		  </tbody>
    </table> -->

<!--  <div style="width: 90%;margin-left:5%;margin-right:5%">
    	<ul>
    		<li>
    			المستلم :
    		</li>
    		<br>

    		<li>
    		 الاسم :
    		</li>
    		<br>

    		<li>
    			التوقيع :
    		</li>
    	</ul>
    </div> -->

</div>


<br class="clr"/>
</div>
</div></div>
</div>
<style>
@page { size: auto;  margin: 0mm; }
</style>