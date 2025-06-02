<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        DevDays 作成フォーム
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900">
                <section class="text-gray-600 body-font relative">
                    <form action="{{ route('counts.store') }}" method="POST">
                        @csrf

                        <div class="container px-5 mx-auto">
                        <div class="lg:w-1/2 md:w-2/3 mx-auto">
                            <div class="flex flex-wrap -m-2">
                                {{-- タイトル --}}
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="title" class="leading-7 text-sm text-gray-600">ポートフォリオ名</label>
                                        <input type="text" id="title" name="title" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                                    </div>
                                </div>
                                {{-- 作成開始日 --}}
                                <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="started_at" class="leading-7 text-sm text-gray-600">作成開始日</label>
                                        <input type="date" id="started_at" name="started_at" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                         <x-input-error :messages="$errors->get('started_at')" class="mt-2" />
                                    </div>
                                </div>
                                {{-- メモ --}}
                                <div class="p-2 w-full">
                                    <div class="relative">
                                    <label for="memo" class="leading-7 text-sm text-gray-600">メモ欄</label>
                                    <textarea id="memo" name="memo" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-y leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                     <x-input-error :messages="$errors->get('memo')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="p-2 w-full">
                                    <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">作成する</button>
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

{{-- 日付クリック有効範囲を全域にする --}}
<script>
document.getElementById("started_at").addEventListener("click", function() {
    this.showPicker(); // Chrome でカレンダーを開く
});
</script>

</x-app-layout>