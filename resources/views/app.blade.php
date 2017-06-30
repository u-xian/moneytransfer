<!DOCTYPE html>
<html lang="en" ng-app="MoneyTransferApp">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MoneyTransfer-International</title>

    <!-- Bootstrap -->
    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/css/jquery.bxslider.css') }}">
	<link rel="stylesheet" href="{{ asset('/css/isotope.css') }}" type="text/css" media="screen" />	
	<link rel="stylesheet" href="{{ asset('/css/animate.css') }}">
	<link rel="stylesheet" href="{{ asset('/js/fancybox/jquery.fancybox.css') }}" type="text/css" media="screen" />
	<link rel="stylesheet" href="{{ asset('/css/prettyPhoto.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/bootstrap-datetimepicker.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('/css/style.css') }}"/>	
    <!-- =======================================================
        Theme Name: Multi
        Theme URL: https://bootstrapmade.com/multi-responsive-bootstrap-template/
        Author: BootstrapMade
        Author URL: https://bootstrapmade.com
    ======================================================= -->
  </head>
  <body ng-controller="mainController">
	<div ng-include src="'views/includes/header.html'"></div>
        <ng-view></ng-view>
	<div ng-include src="'views/includes/footer.html'"></div>
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->	
    <script src="{{ asset('/js/jquery-2.1.1.min.js') }} "></script>	
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('/js/wow.min.js') }}"></script>
	<script src="{{ asset('/js/fancybox/jquery.fancybox.pack.js') }}"></script>
	<script src="{{ asset('/js/jquery.easing.1.3.js') }}"></script>
	<script src="{{ asset('/js/jquery.bxslider.min.js') }}"></script>
	<script src="{{ asset('/js/jquery.prettyPhoto.js') }}"></script>
	<script src="{{ asset('/js/jquery.isotope.min.js') }} "></script> 
    <script src="{{ asset('/js/moment.js') }}"></script>
    <script src="{{ asset('/js/transition.min.js') }}"></script>
    <script src="{{ asset('/js/bootstrap-datetimepicker.min.js') }}"></script>
	<script src="{{ asset('/js/functions.js') }}"></script>
	
	<!-- Angular JS -->
    <script src="{{ asset('/js/angular.min.js') }}"></script> 
    <script src="{{ asset('/js/angular-route.min.js') }}"></script>
    <script src="{{ asset('/app/app.js') }}"></script>
	
    
</body>
</html>