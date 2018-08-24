<?php namespace Ranking\Commands;

use Laracasts\Commander\CommandHandler;
use Ranking\Score\Contracts\ReviewRepositoryContract as ReviewRepository;

class ReviewMobileOperatorCommandHandler implements CommandHandler
{
    private $repository;

    public function __construct( ReviewRepository $repository )
    {
        $this->repository = $repository;
    }

    public function handle( $command )
    {
        try {
            $result = $this->repository->reviewOperator( $command );

            return array_merge( [ 'message' => 'success' ], $result );
        } catch ( \Exception $e ) {
            return [ 'message' => $e->getMessage() ];
        }
    }
}