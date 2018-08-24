<?php

function ratingPercentage($allRatings, $star)
{
	$sum = array_sum($allRatings);

	if (!$sum) {
		return 0;
	}

	return round(((100 * $allRatings[$star]) / $sum), 2);
}

function preserveCountry($pageUri)
{
	$segments = Request::segments();

	if(count($segments) >= 2) {
		return $pageUri . "/" . $segments[1];
	}

	return $pageUri;
}