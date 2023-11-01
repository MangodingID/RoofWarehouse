<x-filament-panels::page>
    <div class="bg-white border rounded-2xl p-5">
        <div class="flex justify-end">
            <select wire:model="operator" wire:change="refresh" class="c-select mr-2">
                @foreach($this->getOperators() as $row)
                    <option value="{{ $row->id }}" {{ $row->id === $operator ? 'selected' : '' }}>{{ $row->name }}</option>
                @endforeach
            </select>

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
        <table class="table-auto w-full mt-3  border rounded">
            <thead>
                <tr>
                    <th class="border p-2">Tanggal</th>
                    <th class="border p-2">Penggesek</th>
                    <th class="border p-2">Jumlah Bengkulangan</th>
                    <th class="border p-2">Hasil Sirap</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $row)
                    <tr>
                        <td class="border p-2 text-center">{{ $row->date }}</td>
                        <td class="border p-2 text-center">{{ $operatorName }}</td>
                        <td class="border p-2 text-center">{{ $row->logs }}</td>
                        <td class="border p-2 text-center">{{ $row->result }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-filament-panels::page>
