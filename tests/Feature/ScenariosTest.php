<?php

declare(strict_types=1);

namespace SolumDeSignum\Scenarios\Tests\Feature;

use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mockery;
use Orchestra\Testbench\TestCase;
use SolumDeSignum\Scenarios\Scenarios;

class ScenariosTest extends TestCase
{
    use Scenarios;

    /**
     * @param string $name
     * @throws Exception
     */
    public function __construct(string $name)
    {
        parent::__construct($name);
    }

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockConfig();
        $this->mockRequest();
    }

    protected function tearDown(): void
    {
        Mockery::close(); // Ensure Mockery is properly closed
        parent::tearDown();
    }

    /** @test */
    public function itCanSetScenarioBasedOnControllerMethod(): void
    {
        Route::get('/test-route', function () {
            //
        })
            ->name('test.route');

        $route = Route::getRoutes()->get('test.route');

        if ($route) {
            $route->setAction(['method' => 'create']);
        }

        $this->setMethodFromController = true;
        $this->setMethodFromUrl = false;
        $this->scenario = $this->filterPattern('create');
        $this->assertEquals('create', $this->scenario);
    }

    /** @test */
    public function itCanSetScenarioBasedOnUrlSegment(): void
    {
        $this->setMethodFromController = false;
        $this->setMethodFromUrl = true;
        $this->scenario = $this->filterPattern('update');
        $this->assertEquals('update', $this->scenario);
    }

    /** @test */
    public function itThrowsExceptionIfNoSetMethodIsEnabled()
    {
        try {
            $this->setMethodFromController = false;
            $this->setMethodFromUrl = false;
            $this->validateConfiguration();
        } catch (Exception $exception) {
            $this->assertSame('Exception', $exception::class);
            $this->assertSame('Please enable at least one setMethod function.', $exception->getMessage());
        }
    }

    /** @test
     * @throws \Exception
     */
    public function itThrowsExceptionIfBothSetMethodsAreEnabled(): void
    {
        try {
            $this->setMethodFromController = true;
            $this->setMethodFromUrl = true;
            $this->validateConfiguration();
        } catch (Exception $exception) {
            $this->assertSame('Exception', $exception::class);
            $this->assertSame('Please enable only one setMethod function.', $exception->getMessage());
        }
    }

    /** @test */
    public function itThrowsExceptionWhenNoPatternMatches(): void
    {
        try {
            $this->scenario = $this->filterPattern('create', '/restore/im');
            $this->assertNotEquals('restore', $this->scenario);
        } catch (Exception $exception) {
            $this->assertSame('Exception', $exception::class);
            $this->assertSame(
                'No pattern matches found. Check the scenario pattern configuration.',
                $exception->getMessage()
            );
        }
    }

    /** @test */
    public function itThrowsExceptionWhenMethodIsNotSet(): void
    {
        try {
            $this->setMethodFromController = false;
            $this->setMethodFromUrl = false;
            $this->scenario = $this->filterPattern(null);
        } catch (Exception $exception) {
            $this->assertSame('Exception', $exception::class);
            $this->assertSame('Unable to determine the method for pattern filtering.', $exception->getMessage());
        }
    }

    /**
     * @return void
     * @throws BindingResolutionException
     */
    private function mockConfig(): void
    {
        $this->config = $this->app->make('config');
        $this->config->set('scenarios.features.setMethodFromController', true);
        $this->config->set('scenarios.features.setMethodFromUrlSegment', false);
        $this->config->set('scenarios.methods.pattern', '/create|store|update|destroy/im');
    }


    private function mockRequest(): void
    {
        $mockRequest = Mockery::mock(Request::class);
        $mockRequest->shouldReceive('getRequestUri')
            ->andReturn('/test-route/update');
        $this->app->instance(Request::class, $mockRequest);
    }
}
