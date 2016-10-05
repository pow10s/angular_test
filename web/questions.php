<!DOCTYPE html>
<html ng-app="main">
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
	<title>All questions</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/angular.min.js"></script>
	<script src="js/angular-modal-service.js" type="text/javascript"></script>
	<script src="js/main.js"></script>
	
</head>
<body>
<nav class="menu">
	<a href class="askBtn" ng-controller="PopupController" ng-click="showForm()">Ask question</a>
	<div class="search"><label>Filter: <input class="input" ng-model="search.title"></label></div>
</nav>

<div class="tabs" ng-controller="tabsData">
	<input id="tab1" type="radio" name="tabs" checked>
	<label for="tab1" title="Interesting">today</label>

	<input id="tab2" type="radio" name="tabs">
	<label for="tab2" title="week">week</label>

	<input id="tab3" type="radio" name="tabs">
	<label for="tab3" title="month">month</label>

	<section id="content1" ng-repeat="x in newRecord | filter:search:strict ">
		<table>
			<tr>
				<td>
					<div class="votes">
						<span>{{x.votes}}</span>
						<div class="counts">votes</div>
					</div>
				</td>

				<td>
					<div class="answers">
						<span>{{x.answers}}</span>
						<div class="counts">answers</div>
					</div>
				</td>

				<td>
					<div class="view">
						<span>{{x.view}}</span>
						<div class="counts">view</div>
					</div>
				</td>
				<td>
					<table>
						<tr>
							<td>
								<a href="{{x.link}}">{{x.title}}</a>
							</td>
						</tr>
						<tr>
							<td>
								<div class="tags">
									<a class="tag" href="{{x.link}}">{{x.tags}}</a>
								</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</section>

	<section id="content2" ng-repeat="x in weekRecord | filter:search:strict ">
		<table>
			<tr>
				<td>
					<div class="votes">
						<span>{{x.votes}}</span>
						<div class="counts">votes</div>
					</div>
				</td>

				<td>
					<div class="answers">
						<span>{{x.answers}}</span>
						<div class="counts">answers</div>
					</div>
				</td>

				<td>
					<div class="view">
						<span>{{x.view}}</span>
						<div class="counts">view</div>
					</div>
				</td>
				<td>
					<table>
						<tr>
							<td>
								<a href="{{x.link}}">{{x.title}}</a>
							</td>
						</tr>
						<tr>
							<td>
								<div class="tags">
									<a class="tag" href="{{x.link}}">{{x.tags}}</a>
								</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</section>

	<section id="content3" ng-repeat="x in monthRecord | filter:search:strict ">
		<table>
			<tr>
				<td>
					<div class="votes">
						<span>{{x.votes}}</span>
						<div class="counts">votes</div>
					</div>
				</td>

				<td>
					<div class="answers">
						<span>{{x.answers}}</span>
						<div class="counts">answers</div>
					</div>
				</td>

				<td>
					<div class="view">
						<span>{{x.view}}</span>
						<div class="counts">view</div>
					</div>
				</td>
				<td>
					<table>
						<tr>
							<td>
								<a href="{{x.link}}">{{x.title}}</a>
							</td>
						</tr>
						<tr>
							<td>
								<div class="tags">
									<a class="tag" href="{{x.link}}">{{x.tags}}</a>
								</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</section>

</div>
</body>
</html>