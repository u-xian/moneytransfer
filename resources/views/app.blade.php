<!DOCTYPE html>
<html lang="en" ng-app="MoneyTransferApp">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MoneyTransfer-International</title>

    <!-- Bootstrap -->
    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/css/jquery.bxslider.css') }}">
	<link rel="stylesheet" href="{{ asset('/css/isotope.css') }}" type="text/css" media="screen" />	
	<link rel="stylesheet" href="{{ asset('/css/animate.css') }}">
	<link rel="stylesheet" href="{{ asset('/js/fancybox/jquery.fancybox.css') }}" type="text/css" media="screen" />
	<link rel="stylesheet" href="{{ asset('/css/prettyPhoto.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/bootstrap-datetimepicker.min.css') }}" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/foundation/5.4.0/css/normalize.css"/>
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
    <script src="{{ asset('/js/angular-animate.js') }} "></script>
    <script src="{{ asset('/js/angular-sanitize.js') }} "></script>
    <script src="{{ asset('/js/angular-messages.js') }} "></script> 
    <script src="{{ asset('/js/underscore-min.js') }} "></script>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script src=" {{ asset('/js/angular-payments.js') }}"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/spin.js/2.0.1/spin.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/angular-spinner/0.5.1/angular-spinner.js"></script>
    
    <script src="{{ asset('/js/ui-bootstrap-tpls-2.5.0.min.js') }} "></script>
    <script src="{{ asset('/app/Authenticatecontrollers.js') }}"></script>
    <script src="{{ asset('/app/BlogControllers.js') }}"></script>
    <script src="{{ asset('/app/Services.js') }}"></script>
    <script src="{{ asset('/app/app.js') }}"></script>
    
	
    
</body>
</html>