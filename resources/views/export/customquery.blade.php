<table>
    <thead>
        <tr>
            <th> USUARIOS CREADOS </th>
        </tr>
    </thead>

    @foreach ($by_gender as $item)
        <tbody>
            <tr>
                @foreach ($item as $key => $datum)
                    <th> {{ $datum }} </th>
                @endforeach
            </tr>
        </tbody>
    @endforeach

    <thead>
        <tr>
            <th> USUARIOS CREDOS DISCRIMINADOS </th>
        </tr>
    </thead>

    @foreach ($by_genders_discriminated as $item)
        <tbody>
            <tr>
                @foreach ($item as $key => $datum)
                    <th> {{ $datum }} </th>
                @endforeach
            </tr>
        </tbody>
    @endforeach


    <thead>
        <tr>
            <th>ASPIRANTES POSTULADOS A OFERTAS LABORALES </th>
        </tr>
    </thead>

    @foreach ($by_candidates as $item)
        <tbody>
            <tr>
                @foreach ($item as $key => $datum)
                    <th> {{ $datum }} </th>
                @endforeach
            </tr>
        </tbody>
    @endforeach

    <thead>
        <tr>
            <th>DISCRIMINADO ASPIRANTES POSTULADOS A OFERTAS LABORALES </th>
        </tr>
    </thead>

    @foreach ($candidates_by_gender as $item)
        <tbody>
            <tr>
                @foreach ($item as $key => $datum)
                    <th> {{ $datum }} </th>
                @endforeach
            </tr>
        </tbody>
    @endforeach

    <thead>
        <tr>
            <th> CONTRATADOS </th>
        </tr>
    </thead>

    @foreach ($contracts as $item)
        <tbody>
            <tr>
                @foreach ($item as $key => $datum)
                    <th> {{ $datum }} </th>
                @endforeach
            </tr>
        </tbody>
    @endforeach

    <thead>
        <tr>
            <th> DISCRIMINADOS CONTRATADOS </th>
        </tr>
    </thead>

    @foreach ($contracts_by_gender as $item)
        <tbody>
            <tr>
                @foreach ($item as $key => $datum)
                    <th> {{ $datum }} </th>
                @endforeach
            </tr>
        </tbody>
    @endforeach

    <thead>
        <tr>
            <th> EMPRESAS </th>
        </tr>
    </thead>

    @foreach ($companies as $item)
        <tbody>
            <tr>
                @foreach ($item as $key => $datum)
                    <th> {{ $datum }} </th>
                @endforeach
            </tr>
        </tbody>
    @endforeach

</table>
