<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        現在の DevDays
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900">
                <div class="flex flex-col items-center space-y-4">
                    <div class="text-lg font-semibold">『 {{ $counts->title }} 』</div>
                    <div class="text-sm text-gray-600">「 {{ $counts->formatted_started_at }} 」から作成</div>
                
                    <div class="relative w-32 h-32 flex justify-center items-center">
                        <div class="w-full h-full border-4 border-gray-600 rounded-md flex items-center justify-center text-4xl font-bold">
                            {{ $counts->elapsedDays }}
                        </div>
                        <div class="absolute right-[-4rem] top-1/2 -translate-y-1/2 text-sm text-gray-600">
                            日経過
                        </div>
                    </div>
                
                    <div class="flex space-x-4 mt-4">
                        <!-- 作成完了 -->
                        <button class="flex mx-auto text-black bg-red-300 border-0 py-1 px-2 focus:outline-none hover:bg-red-400 rounded text-lg">
                            作成完了
                        </button>
                    
                        <!-- 編集 -->
                        <form action="{{ route('counts.edit', ['count' => $counts->id]) }}">
                            <button class="flex mx-auto text-black bg-green-300 border-0 py-1 px-2 focus:outline-none hover:bg-green-400 rounded text-lg">
                                編集
                            </button>
                        </form>
                    
                        <!-- リセット -->
                        <form action="{{ route('counts.destroy', ['count' => $counts->id]) }}"
                            method="post"
                            id="delete_{{ $counts->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" data-id="{{ $counts->id }}" onclick="deletePost(this)" class="flex mx-auto text-black bg-yellow-200 border-0 py-1 px-2 focus:outline-none hover:bg-yellow-300 rounded text-lg">
                                リセット
                            </button>
                        </form>
                    </div>
                    
                    @if($counts->memo)
                    <div class="mt-6 w-full max-w-md mx-auto bg-gray-100 p-4 rounded shadow text-gray-800">
                        <h3 class="text-md font-bold mb-2">メモ</h3>
                        <p class="text-sm">
                            {{ $counts->memo }}
                        </p>
                    </div>
                    @endif
                </div>
              </div>
          </div>
      </div>
  </div>

<!-- 確認メッセージ -->
<script>
function deletePost(e) {
    'use strict'
    if(confirm('本当に削除していいですか？')) {
        document.getElementById('delete_' + e.dataset.id).submit()
    }
}
</script>

</x-app-layout>
