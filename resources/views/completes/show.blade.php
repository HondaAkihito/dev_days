<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            『 {{ $completedCount->title }} 』の詳細
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <section class="text-gray-600 body-font relative">
                        <div class="container px-5 mx-auto">
                            <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                <div class="flex flex-wrap -m-2">
                                    {{-- 画像 --}}
                                    <div class="p-2 w-full">
                                        <div class="relative">
                                            @if($completedCount->image_path)
                                                <img src="{{ asset('storage/' . $completedCount->image_path) }}"
                                                    alt="ポートフォリオ画像"
                                                    class="w-full h-auto rounded border border-gray-300">
                                            @else
                                                <div class="w-full h-64 flex items-center justify-center border border-dashed border-gray-300 rounded text-gray-400">
                                                    画像は登録されていません
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- 経過日数 --}}
                                    <div class="p-2 w-full">
                                        <div class="relative">
                                            <label class="leading-7 text-sm text-gray-600">経過日数</label>
                                            <div
                                                class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                {{ $completedCount->elapsedDays }}日</div>
                                        </div>
                                    </div>
                                    {{-- 学習期間 --}}
                                    <div class="p-2 w-full">
                                        <div class="relative">
                                            <label class="leading-7 text-sm text-gray-600">学習時間</label>
                                            <div
                                                class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                {{ $completedCount->started_at }} 〜 {{ $completedCount->completed_at }}</div>
                                        </div>
                                    </div>
                                    {{-- URL --}}
                                    <div class="p-2 w-full">
                                        <div class="relative">
                                            <label class="leading-7 text-sm text-gray-600">ポートフォリオURL</label>
                                            <div class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out min-h-10 break-words">
                                                <a href="{{ $completedCount->url }}">
                                                    {{ $completedCount->url }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- メモ欄 --}}
                                    <div class="p-2 w-full">
                                        <div class="relative">
                                            <label class="leading-7 text-sm text-gray-600">コメント</label>
                                            {{-- @if($completedCount->comment) --}}
                                                <div
                                                    class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-6 transition-colors duration-200 ease-in-out min-h-32 break-words overflow-y-auto resize-y">
                                                    {{ $completedCount->comment }}</div>
                                            {{-- @endif --}}
                                        </div>
                                    </div>

                                    {{-- ボタンエリア --}}
                                    <div class="flex justify-center w-full gap-4 pt-2">
                                        {{-- 編集ボタン --}}
                                        <form
                                            action=""
                                            method="get">
                                            <div class=" w-full">
                                                <button
                                                    class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">編集</button>
                                            </div>
                                        </form>
                                        {{-- 削除ボタン --}}
                                        <form
                                            action=""
                                            method="post" id="delete_">
                                            @csrf
                                            @method('DELETE')
                                            <div class="w-full">
                                                <a href="#" data-id=""
                                                    onclick="DeleteService.confirmAndDelete(this)" {{-- resources/js/services/DeleteService.js --}}
                                                    class="flex mx-auto text-white bg-pink-500 border-0 py-2 px-8 focus:outline-none hover:bg-pink-600 rounded text-lg">削除</a>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
