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
                    <div class="text-lg font-semibold">『 {{ $count->title }} 』</div>
                    <div class="text-sm text-gray-600">「 {{ $count->formatted_started_at }} 」から作成</div>
                
                    <div class="relative w-32 h-32 flex justify-center items-center">
                        <div class="w-full h-full border-4 border-gray-600 rounded-md flex items-center justify-center text-4xl font-bold">
                            {{ $count->elapsedDays }}
                        </div>
                        <div class="absolute right-[-4rem] top-1/2 -translate-y-1/2 text-sm text-gray-600">
                            日経過
                        </div>
                    </div>
                
                    <div class="flex space-x-4 mt-4">
                        <form action="{{ route('counts.complete', ['count' => $count->id]) }}"
                            method="post"
                            id="complete_{{ $count->id }}">
                            @csrf
                            <!-- 作成完了 -->
                            <button type="button" 
                                    data-id="{{ $count->id }}" 
                                    data-form="complete"
                                    data-message="本当に完了よろしいですか？"
                                    onclick="confirmAndSubmit(this)"
                                    class="flex mx-auto text-black bg-red-300 border-0 py-1 px-2 focus:outline-none hover:bg-red-400 rounded text-lg">
                                作成完了
                            </button>
                        </form>
                    
                        <!-- 編集 -->
                        <form action="{{ route('counts.edit', ['count' => $count->id]) }}">
                            <button class="flex mx-auto text-black bg-green-300 border-0 py-1 px-2 focus:outline-none hover:bg-green-400 rounded text-lg">
                                編集
                            </button>
                        </form>
                    
                        <!-- リセット -->
                        <form action="{{ route('counts.destroy', ['count' => $count->id]) }}"
                            method="post"
                            id="delete_{{ $count->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" 
                                    data-id="{{ $count->id }}"
                                    data-form="delete"
                                    data-message="本当に削除していいですか？"
                                    onclick="confirmAndSubmit(this)"
                                    class="flex mx-auto text-black bg-yellow-200 border-0 py-1 px-2 focus:outline-none hover:bg-yellow-300 rounded text-lg">
                                リセット
                            </button>
                        </form>
                    </div>
                    
                    @if($count->memo)
                    <div class="mt-6 w-full max-w-md mx-auto bg-gray-100 p-4 rounded shadow text-gray-800">
                        <h3 class="text-md font-bold mb-2">メモ</h3>
                        <p class="text-sm">
                            {{ $count->memo }}
                        </p>
                    </div>
                    @endif
                </div>
              </div>
          </div>
      </div>
  </div>

<script>
// 確認メッセージ(完了時、削除時)
function confirmAndSubmit(el) {
    'use strict';
    const id = el.dataset.id;
    const formId = el.dataset.form;
    const message = el.dataset.message;

    if(confirm(message)) {
        document.getElementById(`${formId}_${id}`).submit();
    }
}
</script>

</x-app-layout>
