<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        『 {{ $completedCount->title }} 』の編集フォーム
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900">
                <section class="text-gray-600 body-font relative">
                    <form action="{{ route('completes.update', ['complete' => $completedCount->id ]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="container px-5 mx-auto">
                        <div class="lg:w-1/2 md:w-2/3 mx-auto">
                            <div class="flex flex-wrap -m-2">
                                {{-- 画像 --}}
                                <div class="p-2 w-full">
                                    <div class="relative mb-4">
                                        <label for="image_path" class="leading-7 text-sm text-gray-600">画像</label><br>
                                        <input type="file" id="image_path" name="image_path" accept=".jpg,.jpeg,.png,.webp,.avif"
                                            class="hidden"
                                            onchange="previewImage(event)">
                                        <label for="image_path"
                                            class="file-upload-btn inline-block px-4 py-1 text-sm text-gray-800 bg-gray-100 border border-gray-300 rounded-md shadow-sm cursor-pointer hover:bg-gray-200 active:bg-gray-300 transition">
                                            ファイルを選択
                                        </label>
                                    </div>
                                    {{-- プレビュー表示 --}}
                                    <div class="relative">
                                        {{-- 常に <img> タグを用意しておく --}}
                                        <img id="image_preview"
                                            src="{{ $completedCount->image_path ? asset('storage/' . $completedCount->image_path) : '' }}"
                                            alt="ポートフォリオ画像"
                                            class="w-full h-auto rounded border border-gray-300 {{ $completedCount->image_path ? '' : 'hidden' }}">
                                        {{-- 初期画像がない場合にだけメッセージを表示 --}}
                                        @unless($completedCount->image_path)
                                            <div id="no_image_text" class="w-full h-64 flex items-center justify-center border border-dashed border-gray-300 rounded text-gray-400">
                                                画像は登録されていません
                                            </div>
                                        @endunless
                                    </div>
                                </div>
                                {{-- タイトル --}}
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="title" class="leading-7 text-sm text-gray-600">ポートフォリオ名</label>
                                        <input type="text" id="title" name="title" value="{{ $completedCount->title }}" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                {{-- 作成開始日 --}}
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="started_at" class="leading-7 text-sm text-gray-600">作成開始日</label>
                                        <input type="date" id="started_at" name="started_at"
                                            value="{{ $completedCount->started_at }}"
                                            class="bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                
                                        <div class="mt-1">
                                            <label for="completed_at" class="leading-7 text-sm text-gray-600">作成完了日</label>
                                            <input type="date" id="completed_at" name="completed_at"
                                                value="{{ $completedCount->completed_at }}"
                                                class="bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        </div>
                                    </div>
                                </div>
                                {{-- 経過日数(リアルタイムで計算) --}}
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label class="leading-7 text-sm text-gray-600">↓ 経過日数 (リアルタイムで計算)</label>
                                        <div id="elapsed_days" class="w-full bg-white bg-opacity-50 rounded border border-gray-300 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            {{ $completedCount->elapsedDays }}日
                                        </div>
                                    </div>
                                </div>
                                {{-- URL --}}
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="url" class="leading-7 text-sm text-gray-600">ポートフォリオURL</label>
                                        <input type="url" id="url" name="url" value="{{ $completedCount->url }}" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                {{-- メモ --}}
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="memo" class="leading-7 text-sm text-gray-600">メモ欄</label>
                                        <textarea id="memo" name="memo" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-y leading-6 transition-colors duration-200 ease-in-out">{{ $completedCount->memo }}</textarea>
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新する</button>
                                </div>
                            </div>
                        </div>
                        </div>
                    </form>
                  </section>
              </div>
          </div>
      </div>
  </div>

<script>
// ----- 日付クリック有効範囲を全域にする ----------------------------------------------------------------------
document.getElementById("started_at").addEventListener("click", function() {
    this.showPicker(); // Chrome でカレンダーを開く
});
document.getElementById("completed_at").addEventListener("click", function() {
    this.showPicker();
});


// ----- 画像のリアルタイムプレビュー ----------------------------------------------------------------------
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('image_preview');
    const noImageText = document.getElementById('no_image_text');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            if (noImageText) {
                noImageText.classList.add('hidden');
            }
        };

        reader.readAsDataURL(input.files[0]);
    }
}

// ----- 経過日数リアルタイム計算 ----------------------------------------------------------------------
function calculateElapsedDays() {
    const startInput = document.getElementById('started_at');
    const endInput = document.getElementById('completed_at');
    const display = document.getElementById('elapsed_days');

    const startDate = new Date(startInput.value);
    const endDate = new Date(endInput.value);

    if(!isNaN(startDate) && !isNaN(endDate)) { // isNaN = 「値が NaN(Not-a-Number)かどうかを判定する」ための関数
        const diffTime = endDate - startDate; // Dateオブジェクト同士を引き算すると、ミリ秒単位(1/1000秒)の差分(number型)の結果を取得できる
        const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24)); // Math.floor() = 小数点以下を切り捨てして整数化
            // ↪︎ 秒を日に変換する際の計算の考え方：https://qiita.com/honaki/items/42af07ad0882fd116088
        display.textContent = `${diffDays}日`;
    } else {
        display.textContent = '―';
    }
}

// 日付変更時にリアルタイム計算
document.getElementById('started_at').addEventListener('change', calculateElapsedDays);
document.getElementById('completed_at').addEventListener('change', calculateElapsedDays);

</script>

</x-app-layout>