@extends('layouts.app')

@section('content')
    <!-- filter section -->
    <div class="row">
        <form class="row g-3 border">
            <div class="col-3">
                <span><strong>All Keywords:</strong></span>
                @foreach($keywords as $index => $keyword_info)
                    @php $keyword_value = $keyword_info->keyword; @endphp
                    <div class="form-check">
                        <input type="checkbox" name="history_filters[]" class="form-check-input history-filters filter-keywords" id="filterKeyword-{{ $keyword_value }}" value="{{ $keyword_value }}">
                        <label class="form-check-label" for="filterKeyword-{{ $keyword_value }}">{{ $keyword_value }} ({{ $keyword_info->found }} times found)</label>
                    </div>
                @endforeach
            </div>
            <!-- Users section -->
            <div class="col-3">
                <span><strong>All Users:</strong></span>
                @foreach($users as $index => $user_info)
                    @php $user = $user_info->user; @endphp
                    <div class="form-check">
                        <input type="checkbox" name="history_filters[]" class="form-check-input history-filters filter-users" id="filterUser-{{ $user }}" value="{{ $user }}">
                        <label class="form-check-label" for="filterUser-{{ $user }}">{{ $user }}</label>
                    </div>
                @endforeach
            </div>
            <!-- Time Range section -->
            <div class="col-3">
                <span><strong>Time Range:</strong></span>
                @php
                    $time_ranges = [ 
                        'yesterday'     => 'Yesterday',
                        'last_week'     => 'Last week',
                        'last_month'    => 'Last month',
                    ];
                @endphp
                @foreach($time_ranges as $time_range_key => $time_range)
                    <div class="form-check">
                        <input type="checkbox" name="history_filters[]" class="form-check-input history-filters filter-time-range" id="filterTimeRange-{{ $time_range_key }}" value="{{ $time_range_key }}">
                        <label class="form-check-label" for="filterTimeRange-{{ $time_range_key }}">See data from {{ $time_range }}</label>
                    </div>
                @endforeach
            </div>
            <!-- Date section -->
            <div class="col-3">
                <span><strong>Select Date:</strong></span>
                <div class="row mb-3">
                    <label for="filterDateFrom" class="col-sm-2 col-form-label">From</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control filter-date filter-date-from" id="filterDateFrom">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="filterDateTo" class="col-sm-2 col-form-label">To</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control filter-date filter-date-to" id="filterDateTo">
                    </div>
                </div>
            </div>

            <input type="reset" class="btn btn-success btn-clear-filters" value="Clear Filters" />
        </form>
    </div><br>

    <!-- search history section -->
    <div class="row">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Keyword</th>
                    <th scope="col">Content</th>
                    <th scope="col">User</th>
                    <th scope="col">Search time</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($histories))
                    @foreach($histories as $index => $history)
                        <tr class="{{ $history->id }}" data-rowkey="{{ $history->id }}">
                            <th scope="row">{{ $history->id }}</th>
                            <td>{{ $history->keyword }}</td>
                            <td>{{ $history->content }}</td>
                            <td>{{ $history->user }}</td>
                            <td>{{ $history->search_time }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // filter by checkbox
            $('.history-filters').on('click', function() {
                filterHistoryContent($);
            });

            // filter by date
            $('.filter-date-from, .filter-date-to').on('change', function() {
                filterHistoryContent($);
            });

            // clear button on click, show all search histories
            $('.btn-clear-filters').on('click', function() {
                $('table > tbody  > tr').each(function(index, tr) { 
                    $(tr).show();
                });
            });
        });

        // ajax request to filter search history content
        function filterHistoryContent($) {
            const selected_keywords = [];
            $('.filter-keywords:checked').each(function (i) {
                selected_keywords[i] = $(this).val();
            });

            const selected_users = [];
            $('.filter-users:checked').each(function (i) {
                selected_users[i] = $(this).val();
            });

            const selected_time_range = [];
            $('.filter-time-range:checked').each(function (i) {
                selected_time_range[i] = $(this).val();
            });

            const date_from   = $('.filter-date-from').val();
            const date_to     = $('.filter-date-to').val();

            if(selected_keywords.length > 0 || selected_users.length > 0 || selected_time_range.length > 0 || date_from != '' || date_to != '') {
                $.ajax({
                    type: 'POST',
                    url: "{{ url('/history-filter') }}",
                    data: {
                        'selected_keywords':    selected_keywords, 
                        'selected_users':       selected_users, 
                        'selected_time_range':  selected_time_range, 
                        'date_from':            date_from, 
                        'date_to':              date_to, 
                    },
                    success: function(data) {
                        const history_ids = data.history_ids;
            
                        if(history_ids.length > 0) {
                            $('table > tbody  > tr').each(function(index, tr) { 
                                const rowkey = parseInt($(tr).attr("data-rowkey"));

                                ( $.inArray(rowkey, history_ids) !== -1 ) ? $(tr).show() : $(tr).hide();
                            });
                        } else {
                            $('table > tbody  > tr').each(function(index, tr) { 
                                $(tr).hide();
                            });
                        }
                    }
                });
            } else {
                $('table > tbody  > tr').each(function(index, tr) { 
                    $(tr).show();
                });
            }
        }
    </script>
@endsection
