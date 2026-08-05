{{-- Aquí está el modal de ping--}}
    <div
        id="pingModal"
        class="hidden fixed inset-0 bg-black/60 z-50 flex items-center justify-center">
        <div class="bg-[#0F172A] w-11/12 max-w-3xl rounded-2xl shadow-2xl overflow-hidden">
            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-800">

                <h2
                    id="pingTitle"
                    class="text-white text-xl font-semibold"
                >
                    📡 Ping
                </h2>

                <button
                    id="closePingBtn"
                    class="text-gray-400 hover:text-white text-xl"
                >
                    ✖
                </button>

            </div>

            {{-- Consola --}}
            <div
                id="pingOutput"
                class="
                    bg-black
                    text-green-400
                    font-mono
                    text-sm
                    p-4
                    h-[400px]
                    overflow-y-auto
                "
            >
            </div>

            {{-- Footer --}}
            <div class="px-6 py-4 border-t border-gray-800 flex justify-end">

                <button
                    id="stopPingBtn"
                    class="
                        bg-red-600 hover:bg-red-500
                        text-white
                        px-4 py-2
                        rounded-xl
                        transition
                    "
                >
                    Detener
                </button>
            </div>
        </div>
    </div>