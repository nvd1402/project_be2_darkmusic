<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.partials.head')
</head>

<body>

<div class="container">
    @include('admin.partials.sidebar')

    <main>
        <!--include file header-->
        @include('admin.partials.header')


        <!--content-->
        <div>
            <h2 class="title">Quản lý doanh thu</h2>
        </div>

        <section class="song-list">
            <h2 class="title" style="margin-top: -50px">Doanh thu</h2>
            <div style="display: flex; align-items: flex-start; gap: 40px;">
            <table class="revenue-table" style="">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Người dùng</th>
                    <th>Gói nâng cấp</th>
                    <th>Chu kỳ</th>
                    <th>Tiền thu</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>NguyenVanA</td>
                    <td>VIP Plus</td>
                    <td>1 tháng</td>
                    <td>35.000 VNĐ</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>NguyenVanA</td>
                    <td>VIP Plus</td>
                    <td>1 tháng</td>
                    <td>35.000 VNĐ</td>
                </tr>

                </tbody>

            </table>
            <div class="info-revenue">
                <h2>Doanh thu</h2>
                <div>
                    <h4>Tổng thu gói plus:<br> <span>#</span></h4>
                    <h4>Tổng thu gói premium:<br> <span>#</span></h4>
                    <h4>Tổng doanh thu:<br> <span>#</span></h4>
                </div>
            </div>
            </div>
        </section>
    </main>
</div>

</div>



<script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
