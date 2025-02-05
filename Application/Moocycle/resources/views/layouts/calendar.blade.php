@extends('layouts.app')
<head>
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
</head>
@section('content')
    <header>
        <div class="title">Calendrier</div>
    </header>
    <main>
        <div id="calendar-controls">
            <button onclick="switchView('year')">Année</button>
            <button onclick="switchView('month')">Mois</button>
            <button onclick="switchView('week')">Semaine</button>
        </div>

        <div id="calendar"></div>
    </main>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script>
        let currentView = 'month';
        let cycleAverages = @json($cycleAverages); // Passer les données des cycles à JavaScript

        const calendarElement = document.getElementById('calendar');

        function renderCalendar(view, date) {
            let startDate, endDate;
            if (view === 'month') {
                startDate = moment(date).startOf('month');
                endDate = moment(date).endOf('month');
            } else if (view === 'week') {
                startDate = moment(date).startOf('week');
                endDate = moment(date).endOf('week');
            } else { // year
                startDate = moment(date).startOf('year');
                endDate = moment(date).endOf('year');
            }

            const numDays = endDate.diff(startDate, 'days') + 1;
            let html = `<h2>${startDate.format('MMMM YYYY')}</h2><div class="calendar-grid">`;

            for (let i = 0; i < numDays; i++) {
                const currentDay = startDate.clone().add(i, 'days');
                html += `
                    <div class="calendar-day" data-date="${currentDay.format('YYYY-MM-DD')}">
                        <span>${currentDay.date()}</span>
                        ${showHeatPrediction(currentDay)}
                    </div>
                `;
            }

            html += '</div>';
            calendarElement.innerHTML = html;
        }

        function showHeatPrediction(date) {
            let predictionHtml = '';
            Object.keys(cycleAverages).forEach(cowId => {
                const avgCycle = cycleAverages[cowId];
                const predictionDate = moment(date).add(avgCycle, 'days');
                if (predictionDate.isSame(date, 'day')) {
                    predictionHtml += `<div class="heat-prediction">Chaleur prévisionnelle pour la vache ${cowId}</div>`;
                }
            });
            return predictionHtml;
        }

        function switchView(view) {
            currentView = view;
            renderCalendar(currentView, moment());
        }

        // Initialiser avec la vue du mois
        renderCalendar(currentView, moment());
    </script>
@endsection

