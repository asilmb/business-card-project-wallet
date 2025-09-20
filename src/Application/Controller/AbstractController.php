<?php

declare(strict_types=1);

namespace App\Application\Controller;

use App\Application\Response\ResponseSerializer;
use Symfony\Contracts\Service\Attribute\Required;

abstract class AbstractController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    protected ResponseSerializer $responseSerializer;

    #[Required]
    public function injectResponseSerializer(ResponseSerializer $responseSerializer): void
    {
        $this->responseSerializer = $responseSerializer;
    }
}
