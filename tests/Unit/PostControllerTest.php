<?php

namespace Tests\Unit;

use App\Http\Middleware\RequireAuthorizationHeader;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    #[Test]
    public function missing_authorization_header()
    {
        $request = new Request;

        $middleware = new RequireAuthorizationHeader();

        $response = $middleware->handle($request, function ($req) {
            $this->fail('Next middleware should not be called when Authorization header is missing');
        });

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['errors' => 'Authorization header is missing']),
            $response->getContent()
        );
    }

    #[Test]
    public function with_authorization_header()
    {
        $request = new Request;

        $request->headers->set('Authorization', 'Bearer some-token');

        $middleware = new RequireAuthorizationHeader();

        $called = false;
        $response = $middleware->handle($request, function ($req) use (&$called) {
            $called = true;
            return new Response('Next called');
        });

        $this->assertTrue($called);
        $this->assertEquals('Next called', $response->getContent());
    }
}
