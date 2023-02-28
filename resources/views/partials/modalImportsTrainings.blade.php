<!-- Modal -->

<div class="modal fade" id="fileModalUpTrainings" tabindex="-1" role="dialog" aria-labelledby="fileModalUpTrainings"
    aria-hidden="true">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="fileModalUpLabel">Importar Listado de checklist</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <form action="{{ route('file-import-trainings') }}" method="post" enctype="multipart/form-data">

                {{ csrf_field() }}

                <div class="modal-body">

                    <input type="text" class="form-control" name="name" placeholder="Titulo">

                    <br>

                    <input type="text" class="form-control" name="topic" placeholder="Tema">

                    <br>

                    <select class="form-control" name="type">

                        <option value="Capacitación">
                            Capacitación
                        </option>

                        <option value="Asesoria">
                            Asesoria
                        </option>

                    </select>

                    <br>

                    <input type="text" class="form-control" name="teacher" placeholder="Profesor">

                    <input type="file" class="custom-up" name="file" id="fileUp">

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                    <button type="submit" class="btn btn-success">Eviar</button>

                </div>

            </form>

        </div>

    </div>

</div>
