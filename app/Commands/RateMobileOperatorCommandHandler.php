<?php namespace Ranking\Commands;

use Laracasts\Commander\CommandHandler;
use Ranking\Score\Contracts\ScoresRepositoryContract as ScoresRepository;

class RateMobileOperatorCommandHandler implements CommandHandler
{

    private $repository;

    public function __construct(ScoresRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($command)
    {
        try {
            $result = $this->repository->rateOperator($command);

            return array_merge( [ 'message' => 'success' ], $result );
        } catch (\Exception $e) {
            return ['message' => $e->getMessage()];
        }
    }
}
