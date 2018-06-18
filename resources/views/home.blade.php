@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="m-0">
                        Available Reports
                    </h4>
                </div>

                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <td>Description</td>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>
                                    <a href="{{ route('crossovers') }}">2018 Crossovers</a>
                                </td>
                                <td>List of voters who until the 5/18 primaries have voted Democrat.</td>
                            </tr>

                            <tr>
                                <td>
                                    <a href="{{ route('firstTimeVoters') }}">First Time Voters (combined parties)</a>
                                </td>
                                <td>Voter who the 5/18 primary vote was their first time to vote.</td>
                            </tr>

                            <tr>
                                <td>
                                    <a href="{{ route('firstTimeVoterRepublican') }}">First Time Voters - Republican Only</a>
                                </td>
                                <td>List of first time voters who voted Republican on 5/18</td>
                            </tr>

                            <tr>
                                <td>
                                    <a href="{{ route('firstTimeVoterDemocrat') }}">First Time Voters - Democrat Only</a>
                                </td>
                                <td>List of first time voters who voted Democrat on 5/18</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
