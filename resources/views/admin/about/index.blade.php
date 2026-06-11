@extends('layouts.app')

@section('title')
About Page Management
@endsection

@section('content')

<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">

            <h5>About Page Management</h5>
            <h6 class="text-muted">
                Manage all about page sections.
            </h6>

            <div class="table-responsive mt-4">

                <table class="table table-bordered">

                    <thead>
                        <tr>
                            <th width="100">#</th>
                            <th>Section</th>
                            <th width="150">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <td>1</td>
                            <td>Hero Section</td>
                            <td>
                                <a href="{{ route('about.hero') }}"
                                   class="btn btn-primary btn-sm">
                                    Edit
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>2</td>
                            <td>Counter Section</td>
                            <td>
                                <a href="{{ route('about.counter') }}"
                                   class="btn btn-primary btn-sm">
                                    Edit
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>3</td>
                            <td>Who We Are</td>
                            <td>
                                <a href="{{ route('about.who-we-are') }}"
                                   class="btn btn-primary btn-sm">
                                    Edit
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>4</td>
                            <td>Academic Highlights</td>
                            <td>
                                <a href="{{ route('about.academic-highlights') }}"
                                   class="btn btn-primary btn-sm">
                                    Edit
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>5</td>
                            <td>Why Choose Us</td>
                            <td>
                                <a href="{{ route('about.why-choose-us') }}"
                                   class="btn btn-primary btn-sm">
                                    Edit
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>6</td>
                            <td>Our Commitments</td>
                            <td>
                                <a href="{{ route('about.commitments') }}"
                                   class="btn btn-primary btn-sm">
                                    Edit
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td>7</td>
                            <td>Join Us</td>
                            <td>
                                <a href="{{ route('about.join-us') }}"
                                   class="btn btn-primary btn-sm">
                                    Edit
                                </a>
                            </td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>
    </div>
</div>

@endsection