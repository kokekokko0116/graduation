<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('資産編集画面') }}
        </h2>
        <div class="hidden sm:flex sm:items-center sm:ml-6">
          <form method="GET" action="{{ route('mastertest.create') }}">
              <select name="series_name" onchange="this.form.submit()">
                  @foreach ($series_names as $series_name)
                      <option value="{{ $series_name->series_name }}" @if ($selected_series_name == $series_name->series_name) selected @endif>
                          {{ $series_name->series_name }}
                      </option>
                  @endforeach
              </select>
          </form>
        </div>
    </x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:w-10/12 md:w-8/10 lg:w-8/12">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white dark:bg-gray-800 border-b border-grey-200 dark:border-gray-800">
          <table class="text-center w-full border-collapse">
            <thead>
              <tr>
                <th class="py-4 px-6 bg-gray-lightest dark:bg-gray-darkest font-bold uppercase text-lg text-gray-dark dark:text-gray-200 border-b border-grey-light dark:border-grey-dark">mastertest</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($mastertests as $mastertest)
              <tr class="hover:bg-gray-lighter">
                <td class="py-4 px-6 border-b border-gray-light dark:border-gray-600">
                  <h3 class="text-left font-bold text-lg text-gray-dark dark:text-gray-200">{{$mastertest-> name}}</h3>
                  <h3 class="text-left font-bold text-lg text-gray-dark dark:text-gray-200">{{$mastertest-> price}}円</h3>
                  <h3 class="text-left font-bold text-lg text-gray-dark dark:text-gray-200">{{$mastertest-> rarerity}}</h3>
                  <div class="flex">
                  <!-- ユーザとの中間テーブルにデータがあるか、所持数は１枚か２枚以上かで条件分岐 -->
                  @if(!$mastertest->users()->where('user_id', Auth::id())->exists())
                    <form action="{{ route('stock',$mastertest) }}" method="POST" class="text-left">
                      @csrf
                      <x-primary-button class="ml-3">
                         {{ __('UP') }}
                      </x-primary-button>
                    </form>
                      <h2 class="mb-6">0</h2>
                      <x-primary-button class="ml-3">
                          {{ __('DOWN') }}
                      </x-primary-button>
                    @elseif($mastertest->users()->wherePivot('user_id', Auth::id())->withPivot('stock')->first()->pivot->stock === 1)
                      <form class="mb-6" action="{{ route('mastertest.increment',$mastertest->id) }}" method="POST">
                        @csrf
                        <x-primary-button class="ml-3">
                          {{ __('UP') }}
                        </x-primary-button>
                      </form>
                      <h2 class="mb-6">{{ $mastertest->users()->wherePivot('user_id', Auth::id())->withPivot('stock')->first()->pivot->stock}}</h2>
                    <form action="{{ route('unstock',$mastertest) }}" method="POST" class="text-left">
                      @csrf
                      <x-primary-button class="ml-3">
                          {{ __('DOWN') }}
                      </x-primary-button>
                    </form>
                    @elseif($mastertest->users()->wherePivot('user_id', Auth::id())->withPivot('stock')->first()->pivot->stock >= 2)
                      <form class="mb-6" action="{{ route('mastertest.increment',$mastertest->id) }}" method="POST">
                        @csrf
                        <x-primary-button class="ml-3">
                          {{ __('UP') }}
                        </x-primary-button>
                      </form>
                      <h2 class="mb-6">{{ $mastertest->users()->wherePivot('user_id', Auth::id())->withPivot('stock')->first()->pivot->stock}}</h2>
                      <form class="mb-6" action="{{ route('mastertest.decrement',$mastertest->id) }}" method="POST">
                        @csrf
                        <x-primary-button class="ml-3">
                          {{ __('DOWN') }}
                        </x-primary-button>
                      </form>
                    @elseif($mastertest->users()->wherePivot('user_id', Auth::id())->withPivot('stock')->first()->pivot->stock === 0)
                      <form class="mb-6" action="{{ route('mastertest.increment',$mastertest->id) }}" method="POST">
                        @csrf
                        <x-primary-button class="ml-3">
                          {{ __('UP') }}
                        </x-primary-button>
                      </form>
                      <h2 class="mb-6">{{ $mastertest->users()->wherePivot('user_id', Auth::id())->withPivot('stock')->first()->pivot->stock}}</h2>
                      <x-primary-button class="ml-3">
                          {{ __('DOWN') }}
                      </x-primary-button>
                    @endif
                    <!-- 更新ボタン -->
                    <!-- 削除ボタン -->
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>