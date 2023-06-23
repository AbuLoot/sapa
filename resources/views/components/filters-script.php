<?php
            $parameters = [];
            $filter_titles = [
                'categories_ids' => 'category_id',
                'projects_ids' => 'project_id'
            ];

            foreach($request->query() as $key => $filter_id) {
                if ($key != 'options_ids') {
                    $parameters[$filter_titles[$key]] = $filter_id;
                }
            }

            $query = collect($parameters)
                ->map(fn ($value) => collect($value)) // ->recursive()
                ->map(fn ($value, $key) => $value->map(fn ($value) => $key.' = "'.$value.'"'))
                ->flatten()
                ->join(' AND ');

            // dd($request->query(), $parameters, $query);