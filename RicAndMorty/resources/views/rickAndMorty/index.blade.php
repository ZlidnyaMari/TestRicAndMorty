
    <div>
        <form method="post" action="{{route('saveRikAndMortyRoute')}}">
            @csrf
            <button>Получить героев</button>
        </form>
    </div>

    @if($person)
        Загружено героев: <p>{{count($person)}}</p>
    @endif

    <div>
        <form method="post" action="{{route('saveEpisodeRoute')}}">
            @csrf
            <button>Получить эпизоды</button>
        </form>
    </div>

    @if($episode)
        Загружено эпизодов: <p>{{count($episode)}}</p>
    @endif
