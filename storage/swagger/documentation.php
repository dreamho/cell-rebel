<?php

/**
 * @SWG\Swagger(
 *     basePath="/api",
 *     schemes={"http", "https"},
 *     host="ranking.dev.sapient.pro",
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="L5 Swagger API",
 *         description="L5 Swagger API description",
 *         @SWG\Contact(
 *             email="info@wirelessranking.com"
 *         )
 *     )
 * )
 */

/**
 * @SWG\SecurityScheme(
 *   securityDefinition="passport",
 *   type="oauth2",
 *   tokenUrl="/oauth/token",
 *   flow="password",
 *   scopes={}
 * )
 */

/**
 * @SWG\Get(
 *      path="/countries",
 *      operationId="countries",
 *      tags={"General"},
 *      summary="Get list of countries",
 *      description="Get list of countries",
 *      @SWG\Response(
 *          response=200,
 *          description="Successful"
 *       ),
 *      @SWG\Response(response=400, description="Bad request"),
 *      security={
 *         {
 *             "oauth2_security_example": {"write:projects", "read:projects"}
 *         }
 *     },
 * )
 *
 */


/**
 * @SWG\Get(
 *      path="/tabstexts",
 *      operationId="tabstexts",
 *      tags={"Ranking"},
 *      summary="Get list of tab labels for home page",
 *      description="Get list of tab labels for home page",
 *      @SWG\Response(
 *          response=200,
 *          description="Successful"
 *       ),
 *      @SWG\Response(response=400, description="Bad request"),
 *      security={
 *         {
 *             "oauth2_security_example": {"write:projects", "read:projects"}
 *         }
 *     },
 * )
 *
 */


/**
 * @SWG\Get(
 *      path="/configs",
 *      operationId="configs",
 *      tags={"General"},
 *      summary="Get config data for tests etc",
 *      description="Get config data for tests etc",
 *      @SWG\Response(
 *          response=200,
 *          description="Successful"
 *       ),
 *      @SWG\Response(response=400, description="Bad request"),
 *      security={
 *         {
 *             "oauth2_security_example": {"write:projects", "read:projects"}
 *         }
 *     },
 * )
 *
 */


/**
 * @SWG\Get(
 *      path="/ranks",
 *      operationId="ranks",
 *      tags={"Ranking"},
 *      summary="Get ranking for all scores categories",
 *      description="Get ranking for all scores categories",
 *      @SWG\Response(
 *          response=200,
 *          description="Successful"
 *       ),
 *      @SWG\Response(response=400, description="Bad request"),
 *      security={
 *         {
 *             "oauth2_security_example": {"write:projects", "read:projects"}
 *         }
 *     },
 * )
 *
 */

/**
 * @SWG\Get(
 *      path="/ranks/all",
 *      operationId="ranks",
 *      tags={"Ranking"},
 *      summary="Get ranking for all scores categories for all countries",
 *      description="Get ranking for all scores categories for all countries",
 *      @SWG\Response(
 *          response=200,
 *          description="Successful"
 *       ),
 *      @SWG\Response(response=400, description="Bad request"),
 *      security={
 *         {
 *             "oauth2_security_example": {"write:projects", "read:projects"}
 *         }
 *     },
 * )
 *
 */


/**
 * @SWG\Get(
 *      path="/rankingNationalExperience",
 *      operationId="rankingNationalExperience",
 *      tags={"Ranking"},
 *      summary="Get ranking by national experience",
 *      description="Get ranking by national experience",
 *      @SWG\Response(
 *          response=200,
 *          description="Successful"
 *       ),
 *      @SWG\Response(response=400, description="Bad request"),
 *      security={
 *         {
 *             "oauth2_security_example": {"write:projects", "read:projects"}
 *         }
 *     },
 * )
 *
 */


/**
 * @SWG\Get(
 *      path="/rankingNationalQuality",
 *      operationId="rankingNationalQuality",
 *      tags={"Ranking"},
 *      summary="Get ranking by national quality",
 *      description="Get ranking by national quality",
 *      @SWG\Response(
 *          response=200,
 *          description="Successful"
 *       ),
 *      @SWG\Response(response=400, description="Bad request"),
 *      security={
 *         {
 *             "oauth2_security_example": {"write:projects", "read:projects"}
 *         }
 *     },
 * )
 *
 */


/**
 * @SWG\Get(
 *      path="/rankingNationalRanking",
 *      operationId="rankingNationalRanking",
 *      tags={"Ranking"},
 *      summary="Get ranking by national ranking",
 *      description="Get ranking by national ranking",
 *      @SWG\Response(
 *          response=200,
 *          description="Successful"
 *       ),
 *      @SWG\Response(response=400, description="Bad request"),
 *      security={
 *         {
 *             "oauth2_security_example": {"write:projects", "read:projects"}
 *         }
 *     },
 * )
 *
 */


/**
 * @SWG\Get(
 *      path="/rankingNationalPrice",
 *      operationId="rankingNationalPrice",
 *      tags={"Ranking"},
 *      summary="Get ranking by national price",
 *      description="Get ranking by national price",
 *      @SWG\Response(
 *          response=200,
 *          description="Successful"
 *       ),
 *      @SWG\Response(response=400, description="Bad request"),
 *      security={
 *         {
 *             "oauth2_security_example": {"write:projects", "read:projects"}
 *         }
 *     },
 * )
 *
 */


/**
 * @SWG\Get(
 *      path="/reviews",
 *      operationId="reviews",
 *      tags={"Reviews"},
 *      summary="Get reviews for all the operators",
 *      description="Get reviews for all the operators",
 *      @SWG\Response(
 *          response=200,
 *          description="Successful"
 *       ),
 *      @SWG\Response(response=400, description="Bad request"),
 *      security={
 *         {
 *             "oauth2_security_example": {"write:projects", "read:projects"}
 *         }
 *     },
 * )
 *
 */


/**
 * @SWG\Post(
 *      path="/operator/rate",
 *      operationId="rateOperator",
 *      tags={"Rate"},
 *      summary="Submit ranking for an operator",
 *      description="Submit ranking for an operator",
  *      @SWG\Parameter(
 *          name="operator_id",
 *          description="Operator id",
 *          required=true,
 *          type="integer",
 *          in="formData"
 *      ),
  *      @SWG\Parameter(
 *          name="ux_rating",
 *          description="User experience rating, 1-5",
 *          required=true,
 *          type="integer",
 *          in="formData"
 *      ),
  *      @SWG\Parameter(
 *          name="recommend_rating",
 *          description="Rating for recommendation, 1-10",
 *          required=true,
 *          type="integer",
 *          in="formData"
 *      ),
  *      @SWG\Parameter(
 *          name="price_rating",
 *          description="Rating for price, 1-5",
 *          required=true,
 *          type="integer",
 *          in="formData"
 *      ),
 *      @SWG\Response(
 *          response=200,
 *          description="Successful"
 *       ),
 *      @SWG\Response(response=400, description="Bad request"),
 *      security={
 *         {
 *             "oauth2_security_example": {"write:projects", "read:projects"}
 *         }
 *     },
 * )
 *
 */


/**
 * @SWG\Post(
 *      path="/operator/review",
 *      operationId="rateOperator",
 *      tags={"Rate"},
 *      summary="Submit review for an operator",
 *      description="Submit review for an operator",
  *      @SWG\Parameter(
 *          name="operator_id",
 *          description="Operator id",
 *          required=true,
 *          type="integer",
 *          in="formData"
 *      ),
  *      @SWG\Parameter(
 *          name="reviewTitle",
 *          description="Title of the review",
 *          required=true,
 *          type="integer",
 *          in="formData"
 *      ),
  *      @SWG\Parameter(
 *          name="reviewText",
 *          description="Details of the review",
 *          required=true,
 *          type="integer",
 *          in="formData"
 *      ),
  *      @SWG\Parameter(
 *          name="reviewerName",
 *          description="Review author name",
 *          required=true,
 *          type="integer",
 *          in="formData"
 *      ),
 *      @SWG\Parameter(
 *          name="ux_rating",
 *          description="User experience rating, 1-5",
 *          required=true,
 *          type="integer",
 *          in="formData"
 *      ),
 *      @SWG\Response(
 *          response=200,
 *          description="Successful"
 *       ),
 *      @SWG\Response(response=400, description="Bad request"),
 *      security={
 *         {
 *             "oauth2_security_example": {"write:projects", "read:projects"}
 *         }
 *     },
 * )
 *
 */


/**
 * @SWG\Get(
 *      path="/about",
 *      operationId="about",
 *      tags={"Pages"},
 *      summary="Get content for the about page",
 *      description="Get content for the about page",
 *      @SWG\Response(
 *          response=200,
 *          description="Successful"
 *       ),
 *      @SWG\Response(response=400, description="Bad request"),
 *      security={
 *         {
 *             "oauth2_security_example": {"write:projects", "read:projects"}
 *         }
 *     },
 * )
 *
 */


/**
 * @SWG\Get(
 *      path="/contact",
 *      operationId="contact",
 *      tags={"Pages"},
 *      summary="Get content for the contact page",
 *      description="Get content for the contact page",
 *      @SWG\Response(
 *          response=200,
 *          description="Successful"
 *       ),
 *      @SWG\Response(response=400, description="Bad request"),
 *      security={
 *         {
 *             "oauth2_security_example": {"write:projects", "read:projects"}
 *         }
 *     },
 * )
 *
 */


/**
 * @SWG\Post(
 *      path="/contact",
 *      operationId="contact",
 *      tags={"Pages"},
 *      summary="Send contact message",
 *      description="Send contact message",
 *      @SWG\Parameter(
 *          name="id",
 *          description="Operator id",
 *          required=true,
 *          type="integer",
 *          in="path"
 *      ),
 *      @SWG\Response(
 *          response=200,
 *          description="Successful"
 *       ),
 *      @SWG\Response(response=400, description="Bad request"),
 *      security={
 *         {
 *             "oauth2_security_example": {"write:projects", "read:projects"}
 *         }
 *     },
 * )
 *
 */