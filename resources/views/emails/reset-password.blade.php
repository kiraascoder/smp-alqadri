<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Reset Password - SMP Al-Qadri
    </title>
</head>


<body
    style="
        margin: 0;
        padding: 0;
        background: #f1f5f9;
        font-family: Arial, Helvetica, sans-serif;
        color: #334155;
    ">

    <table width="100%" cellpadding="0" cellspacing="0" border="0"
        style="
            background: #f1f5f9;
            padding: 40px 15px;
        ">

        <tr>

            <td align="center">


                {{-- CONTAINER --}}
                <table width="100%" cellpadding="0" cellspacing="0" border="0"
                    style="
                        max-width: 600px;
                    ">


                    {{-- SCHOOL NAME --}}
                    <tr>

                        <td align="center"
                            style="
                                padding-bottom: 22px;
                            ">

                            <div
                                style="
                                    font-size: 22px;
                                    font-weight: 700;
                                    color: #0f172a;
                                ">

                                SMP Al-Qadri

                            </div>


                            <div
                                style="
                                    margin-top: 4px;
                                    font-size: 13px;
                                    font-weight: 600;
                                    color: #059669;
                                ">

                                Islamic School

                            </div>

                        </td>

                    </tr>



                    {{-- CARD --}}
                    <tr>

                        <td
                            style="
                                background: #ffffff;
                                border-radius: 16px;
                                overflow: hidden;
                                box-shadow:
                                    0 4px 20px
                                    rgba(15, 23, 42, 0.08);
                            ">


                            {{-- TOP COLOR --}}
                            <div
                                style="
                                    height: 6px;
                                    background:
                                        linear-gradient(
                                            90deg,
                                            #1d4ed8,
                                            #059669
                                        );
                                ">
                            </div>



                            {{-- CONTENT --}}
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">

                                <tr>

                                    <td
                                        style="
                                            padding:
                                                38px
                                                42px
                                                42px;
                                        ">


                                        {{-- ICON --}}
                                        <div
                                            style="
                                                width: 54px;
                                                height: 54px;
                                                line-height: 54px;
                                                text-align: center;
                                                background: #eff6ff;
                                                color: #2563eb;
                                                border-radius: 14px;
                                                font-size: 25px;
                                                margin-bottom: 24px;
                                            ">

                                            🔐

                                        </div>



                                        {{-- TITLE --}}
                                        <h1
                                            style="
                                                margin: 0;
                                                font-size: 24px;
                                                line-height: 1.4;
                                                color: #0f172a;
                                            ">

                                            Reset Password Akun Anda

                                        </h1>


                                        <p
                                            style="
                                                font-size: 16px;
                                                line-height: 1.7;
                                                color: #64748b;
                                                margin:
                                                    18px 0 0;
                                            ">

                                            Assalamu'alaikum
                                            <strong
                                                style="
                                                    color: #334155;
                                                ">

                                                {{ $user->name ?? 'Pengguna' }}

                                            </strong>,

                                        </p>


                                        <p
                                            style="
                                                font-size: 15px;
                                                line-height: 1.7;
                                                color: #64748b;
                                                margin:
                                                    14px 0 0;
                                            ">

                                            Kami menerima permintaan untuk
                                            mengatur ulang password akun Anda
                                            pada Sistem Informasi
                                            SMP Al-Qadri Islamic School.

                                        </p>



                                        {{-- BUTTON --}}
                                        <table cellpadding="0" cellspacing="0" border="0"
                                            style="
                                                margin:
                                                    30px auto;
                                            ">

                                            <tr>

                                                <td align="center"
                                                    style="
                                                        background: #2563eb;
                                                        border-radius: 10px;
                                                    ">

                                                    <a href="{{ $resetUrl }}" target="_blank"
                                                        style="
                                                            display:
                                                                inline-block;
                                                            padding:
                                                                14px 28px;
                                                            color: #ffffff;
                                                            text-decoration:
                                                                none;
                                                            font-weight: 700;
                                                            font-size: 14px;
                                                        ">

                                                        Reset Password

                                                    </a>

                                                </td>

                                            </tr>

                                        </table>



                                        {{-- EXPIRATION --}}
                                        <div
                                            style="
                                                background: #f8fafc;
                                                border:
                                                    1px solid #e2e8f0;
                                                border-radius: 10px;
                                                padding: 15px 18px;
                                                font-size: 13px;
                                                line-height: 1.6;
                                                color: #64748b;
                                            ">

                                            Link reset password ini berlaku
                                            selama
                                            <strong
                                                style="
                                                    color: #334155;
                                                ">
                                                60 menit
                                            </strong>.

                                        </div>



                                        <p
                                            style="
                                                font-size: 14px;
                                                line-height: 1.7;
                                                color: #64748b;
                                                margin:
                                                    24px 0 0;
                                            ">

                                            Jika Anda tidak meminta reset
                                            password, abaikan email ini.
                                            Password akun Anda tidak akan
                                            berubah.

                                        </p>



                                        <div
                                            style="
                                                border-top:
                                                    1px solid #e2e8f0;
                                                margin-top: 28px;
                                                padding-top: 22px;
                                            ">

                                            <p
                                                style="
                                                    margin: 0;
                                                    font-size: 14px;
                                                    line-height: 1.6;
                                                    color: #475569;
                                                ">

                                                Salam,<br>

                                                <strong>
                                                    SMP Al-Qadri Islamic School
                                                </strong>

                                            </p>

                                        </div>

                                    </td>

                                </tr>

                            </table>

                        </td>

                    </tr>



                    {{-- ALTERNATIVE LINK --}}
                    <tr>

                        <td
                            style="
                                padding:
                                    22px 25px 0;
                                text-align: center;
                                font-size: 12px;
                                line-height: 1.6;
                                color: #94a3b8;
                            ">

                            Jika tombol Reset Password tidak dapat digunakan,
                            salin alamat berikut ke browser:

                            <div
                                style="
                                    margin-top: 8px;
                                    word-break: break-all;
                                ">

                                <a href="{{ $resetUrl }}"
                                    style="
                                        color: #2563eb;
                                        text-decoration: none;
                                    ">

                                    {{ $resetUrl }}

                                </a>

                            </div>

                        </td>

                    </tr>



                    {{-- FOOTER --}}
                    <tr>

                        <td align="center"
                            style="
                                padding-top: 28px;
                                font-size: 12px;
                                line-height: 1.6;
                                color: #94a3b8;
                            ">

                            © {{ date('Y') }}
                            SMP Al-Qadri Islamic School

                            <br>

                            Sistem Informasi Sekolah

                        </td>

                    </tr>

                </table>

            </td>

        </tr>

    </table>

</body>

</html>
