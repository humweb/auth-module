@if( ! empty($permissions))
    <h4>Permissions</h4>

    <div class="panel-group accordion" id="accordion">
        @foreach($permissions as $groupName => $permissionsGroup)
            <div class="panel panel-default">
                <div class="panel-heading" group="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#{{ $groupName }}">
                            {{ ucfirst($groupName) }}
                        </a>
                        <i class="indicator fa fa-chevron-{{ $groupName == 'users' ? 'down':'right'}} pull-right"></i>
                    </h4>
                </div>
                <div id="{{ $groupName }}" class="panel-collapse collapse{{ $groupName == 'users' ? ' in':''}}">
                    <div class="panel-body">
                        <table class="table table-nohead">

                            <tbody>
                            <?php $currentSection = ''; ?>
                            @foreach($permissionsGroup as $perm => $meta)
                                <?php

                                $section = ucfirst(explode('.', $perm)[0]);
                                if ($section !== $currentSection) {
                                    $currentSection = $section;
                                    echo '<tr><td class="active" colspan="2"><b>'.$section.'</b></td></tr>';
                                }
                                ?>
                                <tr>
                                    <td class="col-sm-4"><span data-toggle="tooltip" title="{{ $meta['description'] }}">{{ $meta['name'] }}</span></td>
                                    <td class="col-sm-8">
                                    <?php $_hasGroup = isset($entity->permissions[$perm]) && $entity->permissions[$perm] ? true : false; ?>
                                    <?php $_isDenied = (! isset($entity->permissions[$perm]) || isset($entity->permissions[$perm]) && $entity->permissions[$perm] == true) ? false : true; ?>
                                    <label class="radio-inline"><input type="radio" name="permissions[{{ $perm }}]" value="1" {{ $_hasGroup ? 'checked': '' }}/>
                                        Allow</label>
                                    <label class="radio-inline"><input type="radio" name="permissions[{{ $perm }}]" value="0"  {{ $_isDenied ? 'checked': '' }}/>
                                        Deny</label>
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
        $(function(){
            var toggleChevron = function(e) {

                $(e.target)
                        .prev('.panel-heading')
                        .find("i.indicator")
                        .toggleClass('fa-chevron-down fa-chevron-right');
            };

            $('#accordion')
                    .on('hide.bs.collapse', toggleChevron)
                    .on('show.bs.collapse', toggleChevron);
        })
    </script>
@endif