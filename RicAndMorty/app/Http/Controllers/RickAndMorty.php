<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\Location;
use App\Models\Person;
use App\Models\PersonEpisode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class RickAndMorty
{
    public function getRikAndMorty()
    {
        $result = [];
        $url = 'https://rickandmortyapi.com/api/character';

        do {
            $response = Http::get($url);

            $url = $response->json()['info']['next'];

            $result[] = $response->json()['results'];

        } while ($response->json()['info']['next']);

       return $result;
    }

    public function getEpisodes()
    {
        $result = [];
        $url = 'https://rickandmortyapi.com/api/episode';

        do {
            $response = Http::get($url);

            $url = $response->json()['info']['next'];

            $result[] = $response->json()['results'];

        } while ($response->json()['info']['next']);

        return $result;
    }

    public function saveRikAndMorty()
    {
        $response = $this->getRikAndMorty();

        $infoPersons = [];

        foreach ($response as $items) {
            foreach ($items as $item) {
                $infoPersons[] = $item;
            }
        }

        DB::transaction(function () use ($infoPersons) {
            foreach ($infoPersons as $infoPerson) {
                $person = Person::create([
                    'name' => $infoPerson['name'],
                    'status' => $infoPerson['status'],
                    'species' => $infoPerson['species'],
                    'gender' => $infoPerson['gender'],
                    'image' => $infoPerson['image'],
                    'url' => $infoPerson['url'],
                ]);
                if(!empty($infoPerson['location'])) {
                  $infoPerson['location']['person_id'] = $person->id;
                    Location::insert($infoPerson['location']);
                }
            }
        });
    }

    public function saveEpisode()
    {
        $response = $this->getEpisodes();
        $episodes = [];

        foreach ($response as $items) {
            foreach ($items as $item) {
                $episodes[] = $item;
            }
        }

        DB::transaction(function () use ($episodes) {
            foreach ($episodes as $episodeItem) {
                $episode = Episode::create([
                    'episode' => $episodeItem['episode'],
                    'url' => $episodeItem['url'],
                ]);

                if(!empty($episodeItem['characters'])) {
                        $personsId = Person::query()->whereIn('url', $episodeItem['characters'])->get('id')->toArray();

                    foreach ($personsId as &$personId) {
                        $personId['person_id'] = $personId['id'];
                        $personId['episode_id'] = $episode->id;
                        unset($personId['id']);
                    }
                }
                PersonEpisode::insert($personsId);
            }
        });

    }
}
