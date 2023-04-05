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
                  <a href="{{ route('mastertest.show',$mastertest->id) }}">
                    <h3 class="text-left font-bold text-lg text-gray-dark dark:text-gray-200">カード名: {{$mastertest-> name}}</h3>
                    <h3 class="text-left font-bold text-lg text-gray-dark dark:text-gray-200">市場価格: {{explode(',',$mastertest-> price)[0]}} 円</h3>
                    <h3 class="text-left font-bold text-lg text-gray-dark dark:text-gray-200">レアリティ: {{$mastertest-> rarerity}}</h3>
                    <h3 class="text-left font-bold text-lg text-gray-dark dark:text-gray-200">個数: {{ $mastertest->users()->wherePivot('user_id', Auth::id())->withPivot('stock')->first()->pivot->stock}}</h3>
                  </a>
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