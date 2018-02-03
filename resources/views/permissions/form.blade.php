@if( ! empty($permissions))
    <h4>Permissions</h4>

    <div class="accordion" id="accordion">
        @foreach($permissions as $groupName => $permissionsGroup)
            <div class="card card-default">
                <div class="card-header" group="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#{{ $groupName }}">
                    <i class="indicator text-muted align-middle fa fa-chevron-{{ $groupName == 'users' ? 'down':'right'}} float-right"></i>
                    <b>
                        {{ ucfirst($groupName) }}
                    </b>
                </div>
                <div id="{{ $groupName }}" class="card-collapse collapse{{ $groupName == 'users' ? ' in':''}}">
                    <div class="card-body">
                        <table class="table table-nohead">

                            <tbody>
                            <?php $currentSection = ''; ?>
                            @foreach($permissionsGroup as $perm => $meta)
                                <?php

                                $section = ucfirst(explode('.', $perm)[0]);
                                if ($section !== $currentSection) {
                                    $currentSection = $section;
                                    echo '<tr><td class="table-active" colspan="2"><b>'.$section.'</b></td></tr>';
                                }
                                ?>
                                <tr>
                                    <td width="60%">
                                        <span data-toggle="tooltip" title="{{ $meta['description'] }}">{{ $meta['name'] }}</span>
                                    </td>
                                    <td width="40%" class="text-right">
                                        <?php
                                        $_hasGroup = isset($entity->permissions[$perm]) && $entity->permissions[$perm]
                                            ? true : false;
                                        $_isDenied = ( ! isset($entity->permissions[$perm]) || isset($entity->permissions[$perm]) && $entity->permissions[$perm] == true)
                                            ? false : true;
                                        ?>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="permissions[{{ $perm }}]" value="1" {{ $_hasGroup ? 'checked': '' }}/>
                                                Allow
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="permissions[{{ $perm }}]" value="0" {{ $_isDenied ? 'checked': '' }}/>
                                                Deny
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


    <script>
        $(function () {
            var toggleChevron = function (e) {

                $(e.target)
                    .prev('.card-header')
                    .find("i.indicator")
                    .toggleClass('fa-chevron-down fa-chevron-right');
            };

            $('#accordion')
                .on('hide.bs.collapse', toggleChevron)
                .on('show.bs.collapse', toggleChevron);
        })
    </script>
@endif