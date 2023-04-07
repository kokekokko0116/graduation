<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('資産一覧画面') }}
        </h2>
        <div class="hidden sm:flex sm:items-center sm:ml-6">
          <form method="GET" action="{{ route('mastertest.index') }}">
              <select name="series_name" onchange="this.form.submit()">
                  <option value="">すべてのシリーズ</option>
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
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach ($mastertests as $mastertest)
                    <div class="px-2 mb-4">
                        <a href="{{ route('mastertest.show',$mastertest->id) }}" class="block bg-white dark:bg-gray-800 border-b border-grey-200 dark:border-gray-800 p-4 rounded shadow-sm hover:bg-gray-lighter">
                            <div>
                                <h3 class="text-left font-bold text-lg text-gray-dark dark:text-gray-200">カード名: {{$mastertest-> name}}</h3>
                                <h3 class="text-left font-bold text-lg text-gray-dark dark:text-gray-200">市場価格: {{explode(',',$mastertest-> price)[0]}} 円</h3>
                                <h3 class="text-left font-bold text-lg text-gray-dark dark:text-gray-200">レアリティ: {{$mastertest-> rarerity}}</h3>
                                <img src="{{ $mastertest->image_url }}" alt="{{ $mastertest->name }}" class style="height: 160px;"  />
                                <h3 class="text-left font-bold text-lg text-gray-dark dark:text-gray-200">枚数: {{ $mastertest->users()->wherePivot('user_id', Auth::id())->withPivot('stock')->first()->pivot->stock}}</h3>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>


</x-app-layout>