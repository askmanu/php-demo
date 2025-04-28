<?php

/**
* This file defines the application kernel for the La Boot'ique e-commerce platform. 
* 
* The kernel is the core component of any Symfony application that bootstraps the framework, handles HTTP requests, and manages the application's lifecycle. 
* 
* This implementation extends Symfony's base kernel and incorporates the MicroKernelTrait, which provides a streamlined approach to application configuration. 
* 
* The kernel serves as the entry point for all requests to the e-commerce platform, initializing the service container, registering bundles, and dispatching requests to the appropriate controllers.
*/

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;
}
