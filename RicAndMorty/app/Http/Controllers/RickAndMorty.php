<?php

namespace App\Http\Controllers;

use App\Jobs\ExelRickAndMorty;
use App\Models\Episode;
use App\Models\Location;
use App\Models\Person;
use App\Models\PersonEpisode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use Symfony\Component\Process\Process;

class RickAndMorty
{

    public function index(): View
    {
        return view('rickAndMorty.index', [
            'person' => Person::all(),
            'episode' => Episode::all(),
        ]);
    }
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

    public function saveRikAndMorty(): \Illuminate\Http\RedirectResponse
    {
        $response = $this->getRikAndMorty();

        $infoPersons = [];

        foreach ($response as $items) {
            foreach ($items as $item) {
                $infoPersons[] = $item;
            }
        }

        PersonEpisode::query()->truncate();
        Person::query()->truncate();
        Location::query()->truncate();

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
        return redirect()->route('indexRoute');
    }

    public function saveEpisode(): \Illuminate\Http\RedirectResponse
    {
        $response = $this->getEpisodes();
        $episodes = [];

        foreach ($response as $items) {
            foreach ($items as $item) {
                $episodes[] = $item;
            }
        }

        PersonEpisode::query()->truncate();
        Episode::query()->truncate();

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

        return redirect()->route('indexRoute');
    }

    public function saveExel()
    {
        ExelRickAndMorty::dispatch();

        return redirect()->back();
    }
}
