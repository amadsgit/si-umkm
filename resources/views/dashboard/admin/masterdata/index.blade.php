@extends('layouts.dashboard')
@section('title', 'Master Data')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">
    <h1 class="text-2xl font-bold mb-6 flex items-center gap-3">
        <i class="ph ph-database text-2xl text-emerald-700"></i> Master Data
    </h1>

    <!-- Tabs Navigation -->
    <div class="mb-4 border-b border-gray-200">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="tabs" role="tablist">
            <li class="me-2">
                <button class="tab-button inline-block p-4 rounded-t-lg border-b-2 hover:text-blue-600" data-tab="user" type="button">
                    Data User
                </button>
            </li>
            <li class="me-2">
                <button class="tab-button inline-block p-4 rounded-t-lg border-b-2 hover:text-blue-600" data-tab="umkm" type="button">
                    Data UMKM
                </button>
            </li>
            <li class="me-2">
                <button class="tab-button inline-block p-4 rounded-t-lg border-b-2 hover:text-blue-600" data-tab="konsultan" type="button">
                    Data Konsultan
                </button>
            </li>
            <li class="me-2">
                <button class="tab-button inline-block p-4 rounded-t-lg border-b-2 hover:text-blue-600" data-tab="kepala" type="button">
                    Data Kepala UPTD
                </button>
            </li>
        </ul>
    </div>

    <!-- Tab Panes -->
    <div id="tab-content">
        <div id="tab-user" class="tab-pane hidden">
            @include('dashboard.admin.masterdata.tabs.user.user')
        </div>
        <div id="tab-umkm" class="tab-pane hidden">
            @include('dashboard.admin.masterdata.tabs.umkm.umkm')
        </div>
        <div id="tab-konsultan" class="tab-pane hidden">
            @include('dashboard.admin.masterdata.tabs.konsultan.konsultan')
        </div>
        <div id="tab-kepala" class="tab-pane hidden">
            @include('dashboard.admin.masterdata.tabs.kepalauptd.kepala')
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const buttons = document.querySelectorAll(".tab-button");
        const panes = document.querySelectorAll(".tab-pane");

        // Default: show first tab
        panes[0].classList.remove("hidden");
        buttons[0].classList.add("border-blue-600", "text-blue-600");

        buttons.forEach(button => {
            button.addEventListener("click", function () {
                // Hide all panes
                panes.forEach(pane => pane.classList.add("hidden"));
                // Remove active class
                buttons.forEach(btn => btn.classList.remove("border-blue-600", "text-blue-600"));

                // Show selected pane
                const tab = this.getAttribute("data-tab");
                document.getElementById("tab-" + tab).classList.remove("hidden");
                this.classList.add("border-blue-600", "text-blue-600");
            });
        });
    });
</script>
@endpush