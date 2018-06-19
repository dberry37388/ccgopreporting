@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="m-0">
                            Districts
                        </h4>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-4">
                                <ul>
                                    <li>
                                        <a href="{{ route('showPrecinct', 1) }}">District 1</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('showPrecinct', 2) }}">District 2</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('showPrecinct', 3) }}">District 3</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('showPrecinct', 4) }}">District 4</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('showPrecinct', 5) }}">District 5</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('showPrecinct', 6) }}">District 6</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('showPrecinct', 7) }}">District 7</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="col-md-4">
                                <ul>
                                    <li>
                                        <a href="{{ route('showPrecinct', 8) }}">District 8</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('showPrecinct', 9) }}">District 9</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('showPrecinct', 10) }}">District 10</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('showPrecinct', 11) }}">District 11</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('showPrecinct', 12) }}">District 12</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('showPrecinct', 13) }}">District 13</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('showPrecinct', 14) }}">District 14</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="col-md-4">
                                <ul>
                                    <li>
                                        <a href="{{ route('showPrecinct', 15) }}">District 15</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('showPrecinct', 16) }}">District 16</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('showPrecinct', 17) }}">District 17</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('showPrecinct', 18) }}">District 18</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('showPrecinct', 19) }}">District 19</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('showPrecinct', 20) }}">District 20</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('showPrecinct', 21) }}">District 21</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="m-0">
                            Available Reports
                        </h4>
                    </div>

                    <div class="card-body">
                        <p>
                            This data was generated from the most current file available from the Election Commission. Your
                            account should not be shared. Additional users can request access information by contacting
                            Sally Singles. Custom reports can also be requested.
                        </p>

                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr>
                                <td>
                                    <a href="{{ route('walklist') }}">Master Walk List</a>
                                </td>
                                <td>
                                    Master Walk List, containing all precincts. Current through 5/18. <br>
                                    <span class="text-muted">This is a large file and could take longer than normal to download.</span>
                                </td>
                            </tr>

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



                        <h5 class="mb-3 mt-5">Understanding the Columns</h5>

                        <table class="table table-borderless">
                            <thead>
                            <tr>
                                <th>Column</th>
                                <th>Description</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr>
                                <td>LNAME</td>
                                <td>The voter's last name</td>
                            </tr>

                            <tr>
                                <td>ADDRESS</td>
                                <td>The voter's current street address</td>
                            </tr>

                            <tr>
                                <td>PCT</td>
                                <td>The voter's precinct</td>
                            </tr>

                            <tr>
                                <td>T</td>
                                <td>Total time the voter has participated.</td>
                            </tr>

                            <tr>
                                <td>%</td>
                                <td>Percentage of times the voter has voted Republican</td>
                            </tr>

                            <tr>
                                <td>R</td>
                                <td>Republican</td>
                            </tr>

                            <tr>
                                <td>D</td>
                                <td>Democrat</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
