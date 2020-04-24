<?php

declare(strict_types=1);

namespace Tests\integration;

class ProfileTest extends BaseTestCase
{
    /**
     * @var int
     */
    private static $id;

    /**
     * Test Get All Profiles.
     */
    public function testGetProfiles(): void
    {
        $response = $this->runApp('GET', '/api/v1/profiles');

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('success', $result);
        $this->assertStringContainsString('id', $result);
        $this->assertStringContainsString('user_id', $result);
        $this->assertStringContainsString('status', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    /**
     * Test Get One Profile.
     */
    public function testGetProfile(): void
    {
        $response = $this->runApp('GET', '/api/v1/profiles/1');

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('success', $result);
        $this->assertStringContainsString('id', $result);
        $this->assertStringContainsString('user_id', $result);
        $this->assertStringContainsString('status', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    /**
     * Test Get Profile Not Found.
     */
    public function testGetProfileNotFound(): void
    {
        $response = $this->runApp('GET', '/api/v1/profiles/123456789');

        $result = (string) $response->getBody();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringNotContainsString('id', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test Search All Profiles.
     */
    public function testSearchAllProfiles(): void
    {
        $response = $this->runApp('GET', '/api/v1/profiles/search/f');

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('success', $result);
        $this->assertStringContainsString('id', $result);
        $this->assertStringContainsString('user_id', $result);
        $this->assertStringContainsString('username', $result);
        $this->assertStringContainsString('status', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    /**
     * Test Search Profiles By Name.
     */
    public function testSearchProfilesByName(): void
    {
        $response = $this->runApp('GET', '/api/v1/profiles/search/fernando');

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('success', $result);
        $this->assertStringContainsString('id', $result);
        $this->assertStringContainsString('username', $result);
        $this->assertStringContainsString('status', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    /**
     * Test Search Profiles with Status Done.
     */
    public function testSearchProfilesWithStatusDone(): void
    {
        $response = $this->runApp('GET', '/api/v1/profiles/search/?status="actived"');

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('success', $result);
        $this->assertStringContainsString('id', $result);
        $this->assertStringContainsString('username', $result);
        $this->assertStringContainsString('status', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    /**
     * Test Search Profiles with status = blocked.
     */
    public function testSearchProfilesWithStatus(): void
    {
        $response = $this->runApp('GET', '/api/v1/profiles/search/?status="blocked"');

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('success', $result);
        $this->assertStringContainsString('id', $result);
        $this->assertStringContainsString('status', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    /**
     * Test Create Profile.
     */
    public function testCreateProfile(): void
    {
        $response = $this->runApp(
            'POST', '/api/v1/profiles', ['user_id' => 1, 'biography' => 'My bio.']
        );

        $result = (string) $response->getBody();

        self::$id = json_decode($result)->message->id;

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('success', $result);
        $this->assertStringContainsString('id', $result);
        $this->assertStringContainsString('user_id', $result);
        $this->assertStringContainsString('status', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    /**
     * Test Get Profile Created.
     */
    public function testGetProfileCreated(): void
    {
        $response = $this->runApp('GET', '/api/v1/profiles/' . self::$id);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('success', $result);
        $this->assertStringContainsString('id', $result);
        $this->assertStringContainsString('user_id', $result);
        $this->assertStringContainsString('status', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    /**
     * Test Create Profile Without Name.
     */
    public function testCreateProfileWithOutProfileName(): void
    {
        $response = $this->runApp('POST', '/api/v1/profiles');

        $result = (string) $response->getBody();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringNotContainsString('id', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test Create Profile With Invalid ProfileName.
     */
    public function testCreateProfileWithInvalidProfileName(): void
    {
        $response = $this->runApp(
            'POST', '/api/v1/profiles', ['user_id' => 'z', 'status' => 1]
        );

        $result = (string) $response->getBody();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test Create Profile With Invalid Status.
     */
    public function testCreateProfileWithInvalidStatus(): void
    {
        $response = $this->runApp(
            'POST', '/api/v1/profiles', ['user_id' => 'ToDo', 'status' => 123]
        );

        $result = (string) $response->getBody();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test Create Profile Without Authorization Bearer JWT.
     */
    public function testCreateProfileWithoutBearerJWT(): void
    {
        $auth = self::$jwt;
        self::$jwt = '';
        $response = $this->runApp(
            'POST', '/api/v1/profiles', ['user_id' => 'my profile', 'status' => 'actived']
        );
        self::$jwt = $auth;

        $result = (string) $response->getBody();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test Create Profile With Invalid JWT.
     */
    public function testCreateProfileWithInvalidJWT(): void
    {
        $auth = self::$jwt;
        self::$jwt = 'invalidToken';
        $response = $this->runApp(
            'POST', '/api/v1/profiles', ['user_id' => 'my profile', 'status' => 'blocked']
        );
        self::$jwt = $auth;

        $result = (string) $response->getBody();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test Create Profile With Forbidden JWT.
     */
    public function testCreateProfileWithForbiddenJWT(): void
    {
        $auth = self::$jwt;
        self::$jwt = 'Bearer eyJ0eXAiOiJK1NiJ9.eyJzdWIiOiI4Ii';
        $response = $this->runApp(
            'POST', '/api/v1/profiles', ['user_id' => 'my profile', 'status' => 'blocked']
        );
        self::$jwt = $auth;

        $result = (string) $response->getBody();

        $this->assertEquals(403, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test Update Profile.
     */
    public function testUpdateProfile(): void
    {
        $response = $this->runApp(
            'PUT', '/api/v1/profiles/' . self::$id,
            ['user_id' => 'Update Profile', 'biography' => 'Update Desc', 'status' => 'actived']
        );

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('success', $result);
        $this->assertStringContainsString('id', $result);
        $this->assertStringContainsString('user_id', $result);
        $this->assertStringContainsString('status', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    /**
     * Test Update Profile Without Send Data.
     */
    public function testUpdateProfileWithOutSendData(): void
    {
        $response = $this->runApp('PUT', '/api/v1/profiles/' . self::$id);

        $result = (string) $response->getBody();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringNotContainsString('id', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test Update Profile Not Found.
     */
    public function testUpdateProfileNotFound(): void
    {
        $response = $this->runApp(
            'PUT', '/api/v1/profiles/123456789', ['user_id' => 'Profile']
        );

        $result = (string) $response->getBody();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringNotContainsString('id', $result);
        $this->assertStringContainsString('error', $result);
    }

    /**
     * Test Delete Profile.
     */
    public function testDeleteProfile(): void
    {
        $response = $this->runApp('DELETE', '/api/v1/profiles/' . self::$id);

        $result = (string) $response->getBody();

        $this->assertEquals(204, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('success', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    /**
     * Test Delete Profile Not Found.
     */
    public function testDeleteProfileNotFound(): void
    {
        $response = $this->runApp('DELETE', '/api/v1/profiles/123456789');

        $result = (string) $response->getBody();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeaderLine('Content-Type'));
        $this->assertStringNotContainsString('success', $result);
        $this->assertStringNotContainsString('id', $result);
        $this->assertStringContainsString('error', $result);
    }
}
