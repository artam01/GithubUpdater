<?php

namespace App\Http\Controllers;

class GitHubUpdaterController extends Controller
{
    public function updateRepositories()
    {
        $token = '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';
        $client = new Client([
            'base_uri' => 'https://api.github.com/',
            'headers' => [
                'Authorization' => 'token '.$token,
                'Accept' => 'application/vnd.github.v3+json',
            ],
        ]);

        // Fetch list of repositories
        $response = $client->get('user/repos');
        $repositories = json_decode($response->getBody(), true);

        // Process each repository
        foreach ($repositories as $repository) {
            $repoName = $repository['name'];
            $owner = $repository['owner']['login'];

            // Your update logic here
            // For example, update the description of the repository
            $description = 'Updated description for repository '.$repoName;
            $data = ['name' => $repoName, 'description' => $description];

            // Send a PATCH request to update the repository description
            $client->patch("repos/$owner/$repoName", ['json' => $data]);
        }

        return response()->json(['message' => 'Repositories updated successfully.']);
    }
}
