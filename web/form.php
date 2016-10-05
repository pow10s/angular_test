<!DOCTYPE html>
<html ng-app="main">
<head>
	<title>Send form</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/angular.min.js"></script>
	<script src="js/angular-modal-service.js" type="text/javascript"></script>
	<script src="js/main.js"></script>
</head>
<body>
<div id="overlay" style="display: block;" >
	<a href class="close" ng-click="close()">Close</a>
	<div id="content">
		<form 
			name="questionForm" 
			method="POST" role="form" 
			ng-submit="submitForm()" 
			ng-controller="postController">

		<p>Title:</p>

		<p>
		<input 
			type="text" 
			name="title" 
			ng-model="question.title" 
			style="width: 417px; height: 20px;"
			ng-minlength="10" 
			required
			>
			<p style="color:red" ng-show="questionForm.title.$error.minlength">Title is too short.</p>
			<p style="color:red" ng-show="questionForm.title.$error.required">Title is required.</p>
		</p>
		<p>Text:</p>

		<p>
		<textarea 
			name="text" 
			ng-model="question.text" 
			style="width: 417px; height: 82px;"
			ng-minlength="10"
			required
			>

			
		</textarea>
			<p style="color:red" ng-show="questionForm.text.$error.minlength">Text is too short.</p>
			<p style="color:red" ng-show="questionForm.text.$error.required">Text is required.</p>
		</p>
		<p>Tag:</p>
		<p>
		<input 
			name="tags" 
			type="text" 
			ng-model="question.tags" 
			style="width: 417px; height: 20px;"
			ng-minlength="2"
			ng-maxlength="10"
			required
			>
			<p style="color:red" ng-show="questionForm.tags.$error.minlength">Tag is too short.</p>
			<p style="color:red" ng-show="questionForm.tags.$error.maxlength">Tag is too long.</p>
			<p style="color:red" ng-show="questionForm.tags.$error.required">Tag is required.</p>
		</p>
		<p>
		<input 
			class="submitBtn" 
			type="submit" 
			name="submit_btn" 
			value="Ask question"
			ng-disabled="questionForm.$invalid"
			>

		</p>
	</form>
	</div>
</div>
<div id="fade" style="display: block;"></div>
</body>
</html>

