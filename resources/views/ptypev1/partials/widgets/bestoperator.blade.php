<!--
    variables:  $categoryScore [location, operators]
-->

<!-- Best Operator Name & Rating -->
@include('ptypev1.partials.widgets.bestoperator-name-and-rating')
<!-- End Best Operator Name & Rating -->

<!-- Best Operator Score Details -->
@include('ptypev1.partials.widgets.bestoperator-score-details')
<!-- End Best Operator Score Details -->

<!-- Action Buttons -->
@include('ptypev1.partials.widgets.action-buttons', ['operator' => $categoryScore['operators'][0]])
<!-- End Action Buttons -->