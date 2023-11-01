<x-filament-panels::page>
    <div class="bg-white border rounded-2xl p-5">
        <div class="flex justify-end">

            <select wire:model="warehouse" wire:change="refresh" class="c-select mr-2">
                @foreach($this->getWarehouses() as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>

            <select wire:model="month" wire:change="refresh" class="c-select mr-2">
                @foreach(months() as $month => $name)
                    <option value="{{ $month }}" {{ $month == date("m") ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>

            <select wire:model="year" wire:change="refresh" class="c-select">
                @foreach(range(2022, date('Y')) as $i)
                    <option value="{{ $i }}" {{ $i == date("Y") ? 'selected' : '' }}>{{ $i }}</option>
                @endforeach
            </select>

            <x-filament::icon-button
                class="ml-2 mr-0.5 bg-blue-500 hover:bg-blue-600 hover:text-white text-white mt-0.5"
                icon="heroicon-o-arrow-down-tray"
                wire:click="export"
            >

            </x-filament::icon-button>
        </div>
        <table class="table-auto w-full mt-3 border rounded">
            <thead>
                <tr>
                    <th class="border p-2" rowspan="2">NAMA</th>
                    <th class="border p-2" colspan="{{ $this->maxDays() }}">TANGGAL</th>
                    <th class="border p-2" rowspan="2">SUB TOTAL</th>
                </tr>
                <tr>
                    @foreach(range(1, $this->maxDays()) as $date)
                        <th class="border p-2 text-center text-sm">{{ $date < 10 ? '0' . $date : $date }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($data as $row)
                    @php($grandTotal += $row['data']->sum())
                    <tr>
                        <td class="border p-2">{{ $row['name'] }}</td>
                        @foreach($row['data'] as $amount)
                            <td class="border p-2 text-center text-sm {{ $amount === 0 ? 'text-white' : '' }} {{ $amount === 0 ? 'bg-rose-400' : '' }}">
                                {{ $amount === 0 ? '' : $amount }}
                            </td>
                        @endforeach
                        <td class="border p-2 text-center font-semibold">{{ $row['data']->sum() }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td class="border p-2"></td>
                    <td class="border p-2 text-end font-semibold" colspan="{{ $this->maxDays() }}">GRAND TOTAL</td>
                    <td class="border p-2 text-center font-semibold">{{ $grandTotal }}</td>
                </tr>
            </tbody>
        </table>
</x-filament-panels::page>
