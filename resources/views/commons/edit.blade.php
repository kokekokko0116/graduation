
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('資産編集画面') }}
        </h2>

        <div class="flex items-center justify-center h-full w-full">
            <form method="GET" action="{{ route('mastertest.create') }}" class="w-full max-w-md">
                <div class="flex items-center bg-white dark:bg-gray-800 rounded-md overflow-hidden">
                    <select name="series_name" onchange="this.form.submit()" class="w-full px-3 py-2 text-gray-700 dark:text-gray-300 bg-transparent focus:outline-none">
                        @foreach ($series_names as $series_name)
                            <option value="{{ $series_name->series_name }}" @if ($selected_series_name == $series_name->series_name) selected @endif>
                                {{ $series_name->series_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

    </x-slot>

      <div class="py-12 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:w-10/12 md:w-8/10 lg:w-8/12">
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white dark:bg-gray-800 border-b border-grey-200 dark:border-gray-800">
              <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($mastertests as $mastertest)
                <div class="px-2 mb-4">
                  <a href="{{ route('mastertest.show',$mastertest->id) }}" class="block bg-gray-100 dark:bg-gray-700 border-b border-grey-200 dark:border-gray-800 p-4 rounded shadow-sm hover:bg-gray-300 dark:hover:bg-gray-500">
                    <div class="flex flex-col items-center justify-center space-y-4">
                      <h3 class="font-bold text-lg text-gray-800 dark:text-gray-200">{{$mastertest-> name}}</h3>
                      <h3 class="font-semibold text-base text-gray-600 dark:text-gray-300">レアリティ: {{$mastertest-> rarerity}}</h3>
                      <img src="{{ $mastertest->image_url }}" alt="{{ $mastertest->name }}" class="h-48 sm:h-56 md:h-64 lg:h-80" />
                      <h3 class="font-semibold text-base text-gray-600 dark:text-gray-300">価値: {{explode(',',$mastertest-> price)[0]}} 円</h3>
                    </div>
                    <div class="flex items-center justify-center">
                    <!-- ユーザとの中間テーブルにデータがあるか、所持数は１枚か２枚以上かで条件分岐 -->
                    @if(!$mastertest->users()->where('user_id', Auth::id())->exists())
                      <form class="" action="{{ route('stock',$mastertest) }}" method="POST">
                        @csrf
                        <x-primary-button class="ml-3">
                           {{ __('+') }}
                        </x-primary-button>
                      </form>
                      <div class="">
                        <h2 class="ml-3">0</h2>
                      </div>
                      <div class="">
                        <x-primary-button class="ml-3">
                            {{ __('-') }}
                        </x-primary-button>
                      </div>
                      @elseif($mastertest->users()->wherePivot('user_id', Auth::id())->withPivot('stock')->first()->pivot->stock === 1)
                        <form class="" action="{{ route('mastertest.increment',$mastertest->id) }}" method="POST">
                          @csrf
                          <x-primary-button class="ml-3">
                            {{ __('+') }}
                          </x-primary-button>
                        </form>
                        <h2 class="">{{ $mastertest->users()->wherePivot('user_id', Auth::id())->withPivot('stock')->first()->pivot->stock}}</h2>
                      <form class="" action="{{ route('unstock',$mastertest) }}" method="POST">
                        @csrf
                        <x-primary-button class="ml-3">
                            {{ __('-') }}
                        </x-primary-button>
                      </form>
                      @elseif($mastertest->users()->wherePivot('user_id', Auth::id())->withPivot('stock')->first()->pivot->stock >= 2)
                        <form class="" action="{{ route('mastertest.increment',$mastertest->id) }}" method="POST">
                          @csrf
                          <x-primary-button class="ml-3">
                            {{ __('+') }}
                          </x-primary-button>
                        </form>
                        <h2 class="">{{ $mastertest->users()->wherePivot('user_id', Auth::id())->withPivot('stock')->first()->pivot->stock}}</h2>
                        <form class="" action="{{ route('mastertest.decrement',$mastertest->id) }}" method="POST">
                          @csrf
                          <x-primary-button class="ml-3">
                            {{ __('-') }}
                          </x-primary-button>
                        </form>
                      @elseif($mastertest->users()->wherePivot('user_id', Auth::id())->withPivot('stock')->first()->pivot->stock === 0)
                        <form class="" action="{{ route('mastertest.increment',$mastertest->id) }}" method="POST">
                            @csrf
                            <x-primary-button class="ml-3">
                                {{ __('+') }}
                            </x-primary-button>
                        </form>
                        <div class="flex items-center h-10 ">
                          <h2 class="">{{ $mastertest->users()->wherePivot('user_id', Auth::id())->withPivot('stock')->first()->pivot->stock}}</h2>
                        </div>
                        <x-primary-button class="ml-3">
                            {{ __('-') }}
                        </x-primary-button>
                      @endif
                      
                    </div>
                  </a>
              </div>
            @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:w-10/12 md:w-8/10 lg:w-8/12">
        <div class="flex justify-center">
            {{ $mastertests->appends(['series_name' => $selected_series_name])->links('components.custom-pagination-links') }}
        </div>
    </div>
</div>
</x-app-layout>