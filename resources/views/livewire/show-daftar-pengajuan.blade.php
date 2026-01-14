@php
    use Carbon\Carbon;
@endphp
<div>
    <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
        <div class="w-full md:w-1/5">
            <form class="flex items-center">
                <label for="simple-search" class="sr-only">Search</label>
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="ti ti-search text-lg text-gray-500 dark:text-gray-400"></i>
                    </div>
                    <input wire:model.live="search" type="text" id="simple-search"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="cari pengajuan..." required="">
                </div>
            </form>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table id="dataIkuTable" class="w-full text-sm text-left rtl:text-left">
            <thead class="text-md text-gray-700 uppercase bg-gray-100 h-full">
                <tr class="h-full">
                    <th scope="col" class="p-4 w-4 text-left">
                        No
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-left">
                        Nama
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-left whitespace-nowrap">
                        Asal Instansi
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-left whitespace-nowrap">
                        Jenis Magang
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-center whitespace-nowrap">
                        status
                    </th>
                    <th scope="col" class="px-6 py-3 border-l border-white text-center whitespace-nowrap">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengajuan as $index => $data)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="py-4 px-6 w-[30px]">{{ $pengajuan->firstItem() + $index }}</td>
                        <td class="py-4 px-6 text-left">
                            {{ $data->user->name }}
                        </td>
                        <td class="py-4 px-6 text-left whitespace-nowrap">{{ $data->user->institusi }}</td>
                        </td>
                        <td class="py-4 px-6 text-left">{{ $data->jenis_magang }}
                        </td>
                        <td class="py-4 px-6 text-center">
                            <div
                                class="text-[13px] w-fit items-center mx-auto">
                                @if ($data->status_pengajuan == 'waiting')
                                    <p class="text-amber-700 border-amber-600 bg-amber-50 border-2 rounded-full whitespace-nowrap px-3 py-1 ">Menunggu Diperiksa</p>
                                @elseif($data->status_pengajuan == 'accept-first')
                                    @if (is_null($data->surat_pengantar))
                                        <p class="text-green-700 border-green-600 bg-green-50 border-2 rounded-full whitespace-nowrap px-3 py-1 ">Menunggu Surat Balasan</p>
                                    @else
                                        <p class="text-blue-700 border-blue-600 bg-blue-50 border-2 rounded-full whitespace-nowrap px-3 py-1 ">Menunggu Persetujuan Final</p>
                                    @endif
                                @endif
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <a href="/detail-pengajuan/{{$data->id}}"
                                class="pjax-link w-fit mx-auto flex items-center gap-1 bg-blue-600 border border-transparent px-2 py-1 rounded-lg text-white hover:bg-blue-100 hover:border hover:border-blue-600 hover:text-blue-600 transition-all duration-200">
                                <i class="ti ti-files"></i>
                                <p class="text-sm whitespace-nowrap">Review</p>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white border-b hover:bg-gray-50 text-center">
                        <td colspan="7" class="py-10 text-gray-300">
                            <i class="ti ti-file-x text-4xl"></i>
                            <p class="font-semibold text-md">Tidak ada data pengajuan</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <!-- Custom Pagination -->
        {{ $pengajuan->links('vendor.pagination.custom-pagination') }}
    </div>
</div>
