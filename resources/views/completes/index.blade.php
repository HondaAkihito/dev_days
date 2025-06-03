<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        完了 DevDays 一覧
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900">
                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                    <table class="whitespace-nowrap table-auto w-full text-left">
                      <thead>
                        <tr>
                          <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl-lg">詳細</th>
                          <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">タイトル</th>
                          <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">経過日数</th>
                          <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr-lg">作成期間</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($completedCounts as $completedCount)
                        <tr>
                          <td class="border-t-2 border-gray-200 px-4 py-3">#</td>
                          <td class="border-t-2 border-gray-200 px-4 py-3">{{ $completedCount->title }}</td>
                          <td class="border-t-2 border-gray-200 px-4 py-3">{{ $completedCount->elapsedDays }}日</td>
                          <td class="border-t-2 border-gray-200 px-4 py-3 text-lg text-gray-900">{{ $completedCount->started_at }} 〜 {{ $completedCount->completed_at }}</td>
                            <input name="plan" type="radio">
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
              </div>
          </div>
      </div>
  </div>

</x-app-layout>
