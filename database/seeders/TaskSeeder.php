<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\task;
use App\Models\task_question;
use App\Models\question_answer;

class TaskSeeder extends Seeder
{
    public function run()
    {


        $task = Task::create([
            'class_subject_id' => '1',
            'finished' =>'1',
            'total_grade'=>15
        ]);

        // Create task questions
        $questions = [
            [
                'the_question' => ' ما  جمع كلمة قارب ?',
                'question_grade' => 5,
            ],
            [
                'the_question' => ':من هو قائل البيت التالي: يا ناشر العلم في هذي البلاد  وفقت نشر العلم مثل الجهاد?',
                'question_grade' => 5,
            ],
            ['the_question' => 'ما مرادف كلمة المنية',
            'question_grade' => 5,

            ],
        ];

        $task_questions = [];
        foreach ($questions as $question_data) {
            $task_questions[] = task_question::create([
                'task_id' => $task->id,
                'the_question' => $question_data['the_question'],
                'question_grade' => $question_data['question_grade'],
            ]);
        }

        // Create question answers
        $answers = [
            [
                'task_question_id' => $task_questions[0]->id,
                'the_answer' => 'قوارب',
                'correct_answer' => true,
            ],
            [
                'task_question_id' => $task_questions[0]->id,
                'the_answer' => 'قاربات',
                'correct_answer' => false,
            ],
            [
                'task_question_id' => $task_questions[0]->id,
                'the_answer' => 'قراريب',
                'correct_answer' => false,
            ],

            [
                'task_question_id' => $task_questions[1]->id,
                'the_answer' => 'أحمد شوقي',
                'correct_answer' => true,
            ],
            [
                'task_question_id' => $task_questions[1]->id,
                'the_answer' => 'المتنبي',
                'correct_answer' => false,
            ],
            [
                'task_question_id' => $task_questions[1]->id,
                'the_answer' => 'نزار قباني',
                'correct_answer' => false,
            ],
            [
                'task_question_id' => $task_questions[2]->id,
                'the_answer' => 'الأمنية',
                'correct_answer' => false,
            ],  [
                'task_question_id' => $task_questions[2]->id,
                'the_answer' => 'الموت',
                'correct_answer' => true,
            ],  [
                'task_question_id' => $task_questions[2]->id,
                'the_answer' => 'السعادة',
                'correct_answer' => false,
            ],

        ];

        foreach ($answers as $answer_data) {
            question_answer::create($answer_data);
        }
        $task = Task::create([
            'class_subject_id' => 2,
            'finished' =>'1',
            'total_grade'=> 15
        ]);

        // Create task questions
        $questions = [
            [
                'the_question' => 'i eat _ apple ?',
                'question_grade' => 5,
            ],
            [
                'the_question' => 'What is meaning of area?',
                'question_grade' => 5,
            ],
            [
                'the_question' => 'What is the opposite of the word front?',
                'question_grade' => 5,
            ],

        ];
        $task_questions = [];
        foreach ($questions as $question_data) {
            $task_questions[] = task_question::create([
                'task_id' => $task->id,
                'the_question' => $question_data['the_question'],
                'question_grade' => $question_data['question_grade'],
            ]);
        }

        // Create question answers
        $answers = [
            [
                'task_question_id' => $task_questions[0]->id,
                'the_answer' => 'an',
                'correct_answer' => true,
            ],
            [
                'task_question_id' => $task_questions[0]->id,
                'the_answer' => 'a',
                'correct_answer' => false,
            ],
            [
                'task_question_id' => $task_questions[0]->id,
                'the_answer' => 'no thing',
                'correct_answer' => false,
            ],

            [
                'task_question_id' => $task_questions[1]->id,
                'the_answer' => 'reagon',
                'correct_answer' => true,
            ],
            [
                'task_question_id' => $task_questions[1]->id,
                'the_answer' => 'array',
                'correct_answer' => false,
            ],
            [
                'task_question_id' => $task_questions[1]->id,
                'the_answer' => 'country',
                'correct_answer' => false,
            ],
            [
                'task_question_id' => $task_questions[2]->id,
                'the_answer' => 'back',
                'correct_answer' => true,
            ],
            [
                'task_question_id' => $task_questions[2]->id,
                'the_answer' => 'above',
                'correct_answer' => false,
            ],
            [
                'task_question_id' => $task_questions[2]->id,
                'the_answer' => 'up',
                'correct_answer' => false,
            ],
        ];

        foreach ($answers as $answer_data) {
            question_answer::create($answer_data);
        }


        $task = Task::create([
            'class_subject_id' => '3',
            'finished' =>'1',
            'total_grade'=>15
        ]);

        // Create task questions
        $questions = [
            [
                'the_question' => 'What is meaning l ecole?',
                'question_grade' => 5,
            ],
            [
                'the_question' => 'What is the capital of France?',
                'question_grade' => 10,
            ],
        ];

        $task_questions = [];
        foreach ($questions as $question_data) {
            $task_questions[] = task_question::create([
                'task_id' => $task->id,
                'the_question' => $question_data['the_question'],
                'question_grade' => $question_data['question_grade'],
            ]);
        }

        // Create question answers
        $answers = [
            [
                'task_question_id' => $task_questions[0]->id,
                'the_answer' => 'مدرسة',
                'correct_answer' => true,
            ],
            [
                'task_question_id' => $task_questions[0]->id,
                'the_answer' => 'بيت',
                'correct_answer' => false,
            ],
            [
                'task_question_id' => $task_questions[1]->id,
                'the_answer' => 'Paris',
                'correct_answer' => true,
            ],
            [
                'task_question_id' => $task_questions[1]->id,
                'the_answer' => 'London',
                'correct_answer' => false,
            ],
        ];

        foreach ($answers as $answer_data) {
            question_answer::create($answer_data);
        }

        $task = Task::create([
            'class_subject_id' => '4',
            'finished' =>'1',
            'total_grade'=>15
        ]);
        $questions = [
            [
                'the_question' => 'ما هي العولمة?',
                'question_grade' => 5,
            ],
            [
                'the_question' => 'ما هي اقسام العولمة?',
                'question_grade' => 10,
            ],
        ];

        $task_questions = [];
        foreach ($questions as $question_data) {
            $task_questions[] = task_question::create([
                'task_id' => $task->id,
                'the_question' => $question_data['the_question'],
                'question_grade' => $question_data['question_grade'],
            ]);
        }
        $answers = [
            [
                'task_question_id' => $task_questions[0]->id,
                'the_answer' => 'تبادل ثقافي',
                'correct_answer' => false,
            ],
            [
                'task_question_id' => $task_questions[0]->id,
                'the_answer' => 'سحق الخصوصية',
                'correct_answer' => false,
            ],
            [
                'task_question_id' => $task_questions[0]->id,
                'the_answer' => 'كل ما سبق صحيح',
                'correct_answer' => true,
            ],

            [
                'task_question_id' => $task_questions[1]->id,
                'the_answer' => 'اقتصادية',
                'correct_answer' => false,
            ],
            [
                'task_question_id' => $task_questions[1]->id,
                'the_answer' => 'سياسية',
                'correct_answer' => false,
            ],
            [
                'task_question_id' => $task_questions[1]->id,
                'the_answer' => 'كل ما سبق صحيح',
                'correct_answer' => true,
            ],
        ];

        foreach ($answers as $answer_data) {
            question_answer::create($answer_data);
        }

        $task = Task::create([
            'class_subject_id' => '5',
            'finished' =>'1',
            'total_grade'=>60
        ]);
        $questions = [
            [
                'the_question' => 'what is x in x*x = 49 ?',
                'question_grade' => 5,
            ],
            [
                'the_question' => 'what is 2x+3=21?',
                'question_grade' => 5,
            ],
            [
                'the_question' => 'what is square root for 625?',
                'question_grade' => 10,
            ],
            [
                'the_question' => 'what is (x/2)*4=2 ?',
                'question_grade' => 10,
            ],
            [
                'the_question' => 'what is r in cycle ?',
                'question_grade' => 5,
            ],
            [
                'the_question' => 'when the triangle be standalone?',
                'question_grade' => 10,

            [
                'the_question' => 'what is the area for square?',
                'question_grade' => 5,
            ],
            ],
            [
                'the_question' => 'what is 2+2 ?',
                'question_grade' => 10,
            ],

        ];




        $task_questions = [];
        foreach ($questions as $question_data) {
            $task_questions[] = task_question::create([
                'task_id' => $task->id,
                'the_question' => $question_data['the_question'],
                'question_grade' => $question_data['question_grade'],
            ]);
        }
        $answers = [
            [
                'task_question_id' => $task_questions[0]->id,
                'the_answer' => '6',
                'correct_answer' => false,
            ],
            [
                'task_question_id' => $task_questions[0]->id,
                'the_answer' => '4',
                'correct_answer' => false,
            ],
            [
                'task_question_id' => $task_questions[0]->id,
                'the_answer' => '7   ',
                'correct_answer' => true,
            ],

            [
                'task_question_id' => $task_questions[1]->id,
                'the_answer' => '10',
                'correct_answer' => false,
            ],
            [
                'task_question_id' => $task_questions[1]->id,
                'the_answer' => '11',
                'correct_answer' => false,
            ],
            [
                'task_question_id' => $task_questions[1]->id,
                'the_answer' => ' 9 ',
                'correct_answer' => true,
            ],   [
                'task_question_id' => $task_questions[2]->id,
                'the_answer' => '25',
                'correct_answer' => true,
            ],
            [
                'task_question_id' => $task_questions[2]->id,
                'the_answer' => '35',
                'correct_answer' => false,
            ],
            [
                'task_question_id' => $task_questions[2]->id,
                'the_answer' => ' 12 ',
                'correct_answer' => false,
            ],   [
                'task_question_id' => $task_questions[3]->id,
                'the_answer' => '2',
                'correct_answer' => false,
            ],
            [
                'task_question_id' => $task_questions[3]->id,
                'the_answer' => '1.5',
                'correct_answer' => false,
            ],
            [
                'task_question_id' => $task_questions[3]->id,
                'the_answer' => ' 1',
                'correct_answer' => true,
            ],   [
                'task_question_id' => $task_questions[4]->id,
                'the_answer' => 'قطر الدائرة ',
                'correct_answer' => false,
            ],
            [
                'task_question_id' => $task_questions[4]->id,
                'the_answer' => 'محيط الدائرة',
                'correct_answer' => false,
            ],
            [
                'task_question_id' => $task_questions[4]->id,
                'the_answer' => ' نصف قطر الدائرة ',
                'correct_answer' => true,
            ],   [
                'task_question_id' => $task_questions[5]->id,
                'the_answer' => 'أحد زواياه أكبر من 90 درجة',
                'correct_answer' => false,
            ],
            [
                'task_question_id' => $task_questions[5]->id,
                'the_answer' => ' 90 أحد زواياه تساوي ',
                'correct_answer' => true,
            ],
            [
                'task_question_id' => $task_questions[5]->id,
                'the_answer' => 'ان يكون متساوي الساقين',
                'correct_answer' => false,
            ],   [
                'task_question_id' => $task_questions[6]->id,
                'the_answer' => '2/الطول* العرض',
                'correct_answer' => false,
            ],
            [
                'task_question_id' => $task_questions[6]->id,
                'the_answer' => 'الطول/2*العرض',
                'correct_answer' => false,
            ],
            [
                'task_question_id' => $task_questions[6]->id,
                'the_answer' => ' الطول*العرض ',
                'correct_answer' => true,
            ],
       /*     [
                'task_question_id' => $task_questions[7]->id,
                'the_answer' => '6',
                'correct_answer' => false,
            ],
            [
                'task_question_id' => $task_questions[7]->id,
                'the_answer' => '5',
                'correct_answer' => false,
            ],
            [
                'task_question_id' => $task_questions[7]->id,
                'the_answer' => '4 ',
                'correct_answer' => true,
            ],*/
           ];

        foreach ($answers as $answer_data) {
            question_answer::create($answer_data);
        }
        $task = Task::create([
            'class_subject_id' => '5',
            'finished' =>'1',
            'total_grade'=>60
        ]);
        $questions = [
            [
                'the_question' => 'what is the value of x in 2x + 5 = 11?',
                'question_grade' => 5,
            ],
            [
                'the_question' => 'what is the perimeter of a rectangle with length 6 and width 4?',
                'question_grade' => 10,
            ],
            [
                'the_question' => 'what is the equation of a line that passes through points (2,3) and (4,5)?',
                'question_grade' => 10,
            ],
            [
                'the_question' => 'what is the sum of the interior angles of a hexagon?',
                'question_grade' => 5,
            ],
            [
                'the_question' => 'what is the formula to find the area of a circle?',
                'question_grade' => 10,
            ],
            [
                'the_question' => 'what is the value of y in 3y - 2 = 14?',
                'question_grade' => 5,
            ],
            [
                'the_question' => 'what is the slope of a line that passes through points (1,2) and (3,4)?',
                'question_grade' => 10,
            ],
            [
                'the_question' => 'what is the equation of a circle with center (0,0) and radius 3?',
                'question_grade' => 10,
            ],
        ];
        $task_questions = [];
        foreach ($questions as $question_data) {
            $task_questions[] = task_question::create([
                'task_id' => $task->id,
                'the_question' => $question_data['the_question'],
                'question_grade' => $question_data['question_grade'],
            ]);
        }

      $answers = [
    [
        'task_question_id' => $task_questions[0]->id,
        'the_answer' => '3',
        'correct_answer' => true,
    ],
    [
        'task_question_id' => $task_questions[0]->id,
        'the_answer' => '5',
        'correct_answer' => false,
    ],
    [
        'task_question_id' => $task_questions[0]->id,
        'the_answer' => '9',
        'correct_answer' => false,
    ],

    [
        'task_question_id' => $task_questions[1]->id,
        'the_answer' => '24',
        'correct_answer' => true,
    ],
    [
        'task_question_id' => $task_questions[1]->id,
        'the_answer' => '10',
        'correct_answer' => false,
    ],
    [
        'task_question_id' => $task_questions[1]->id,
        'the_answer' => '12',
        'correct_answer' => false,
    ],

    [
        'task_question_id' => $task_questions[2]->id,
        'the_answer' => 'y = x + 2',
        'correct_answer' => true,
    ],
    [
        'task_question_id' => $task_questions[2]->id,
        'the_answer' => 'y = 2x + 1',
        'correct_answer' => false,
    ],
    [
        'task_question_id' => $task_questions[2]->id,
        'the_answer' => 'y = x - 1',
        'correct_answer' => false,
    ],

    [
        'task_question_id' => $task_questions[3]->id,
        'the_answer' => '120',
        'correct_answer' => true,
    ],
    [
        'task_question_id' => $task_questions[3]->id,
        'the_answer' => '180',
        'correct_answer' => false,
    ],
    [
        'task_question_id' => $task_questions[3]->id,
        'the_answer' => '240',
        'correct_answer' => false,
    ],

    [
        'task_question_id' => $task_questions[4]->id,
        'the_answer' => 'πr^2',
        'correct_answer' => true,
    ],
    [
        'task_question_id' => $task_questions[4]->id,
        'the_answer' => '2πr',
        'correct_answer' => false,
    ],
    [
        'task_question_id' => $task_questions[4]->id,
        'the_answer' => 'πr',
        'correct_answer' => false,
    ],

    [
        'task_question_id' => $task_questions[5]->id,
        'the_answer' => '90 degrees',
        'correct_answer' => true,
    ],
    [
        'task_question_id' => $task_questions[5]->id,
        'the_answer' => '120 degrees',
        'correct_answer' => false,
    ],
    [
        'task_question_id' => $task_questions[5]->id,
        'the_answer' => '180 degrees',
        'correct_answer' => false,
    ],

    [
        'task_question_id' => $task_questions[6]->id,
        'the_answer' => 'y = 2x - 3',
        'correct_answer' => true,
    ],
    [
        'task_question_id' => $task_questions[6]->id,
        'the_answer' => 'y = x + 2',
        'correct_answer' => false,
    ],
    [
        'task_question_id' => $task_questions[6]->id,
        'the_answer' => 'y = 3x - 2',
        'correct_answer' => false,
    ],

    [
        'task_question_id' => $task_questions[7]->id,
        'the_answer' => '(x-3)^2 + (y-4)^2 = 9',
        'correct_answer' => true,
    ],
    [
        'task_question_id' => $task_questions[7]->id,
        'the_answer' => '(x-2)^2 + (y-3)^2 = 4',
        'correct_answer' => false,
    ],
    [
        'task_question_id' => $task_questions[7]->id,
        'the_answer' => '(x-4)^2 + (y-2)^2 = 16',
        'correct_answer' => false,
    ],
];
foreach ($answers as $answer_data) {
    question_answer::create($answer_data);
}


$task = Task::create([
    'class_subject_id' => '5',
    'finished' =>'1',
    'total_grade'=>60
]);
$questions = [
    [
        'the_question' => 'What is the sum of the first 100 natural numbers?',
        'question_grade' => 10,
    ],
    [
        'the_question' => 'If the radius of a circle is 7 cm, what is the circumference?',
        'question_grade' => 5,
    ],
    [
        'the_question' => 'What is the value of x in the equation 3x - 7 = 2x + 8?',
        'question_grade' => 5,
    ],
    [
        'the_question' => 'What is the area of a triangle with a base of 10 cm and a height of 5 cm?',
        'question_grade' => 10,
    ],
    [
        'the_question' => 'What is the volume of a cube with a side length of 3 cm?',
        'question_grade' => 5,
    ],
    [
        'the_question' => 'What is the slope of the line defined by the equation y = 2x + 3?',
        'question_grade' => 10,
    ],
    [
        'the_question' => 'What is the Pythagorean theorem?',
        'question_grade' => 10,
    ],
    [
        'the_question' => 'What is the factorial of 5 (5!)?',
        'question_grade' => 5,
    ],
    [
        'the_question' => 'What is the square root of 225?',
        'question_grade' => 5,
    ],
    [
        'the_question' => 'What is the sum of the interior angles of a pentagon?',
        'question_grade' => 10,
    ],
];$task_questions = [];
foreach ($questions as $question_data) {
    $task_questions[] = task_question::create([
        'task_id' => $task->id,
        'the_question' => $question_data['the_question'],
        'question_grade' => $question_data['question_grade'],
    ]);
}
$Answers = [
    [
        'task_question_id' => $task_questions[0]->id,
        'the_answer' => '5050',
        'correct_answer' => true,
    ],
    [
        'task_question_id' => $task_questions[0]->id,
        'the_answer' => '5000',
        'correct_answer' => false,
    ],
    [
        'task_question_id' => $task_questions[1]->id,
        'the_answer' => '14π cm',
        'correct_answer' => true,
    ],
    [
        'task_question_id' => $task_questions[1]->id,
        'the_answer' => '28 cm',
        'correct_answer' => false,
    ],
    [
        'task_question_id' => $task_questions[2]->id,
        'the_answer' => '15',
        'correct_answer' => true,
    ],
    [
        'task_question_id' => $task_questions[2]->id,
        'the_answer' => '7',
        'correct_answer' => false,
    ],
    [
        'task_question_id' => $task_questions[3]->id,
        'the_answer' => '25 cm²',
        'correct_answer' => true,
    ],
    [
        'task_question_id' => $task_questions[3]->id,
        'the_answer' => '50 cm²',
        'correct_answer' => false,
    ],
    [
        'task_question_id' => $task_questions[4]->id,
        'the_answer' => '27 cm³',
        'correct_answer' => true,
    ],
    [
        'task_question_id' => $task_questions[4]->id,
        'the_answer' => '30 cm³',
        'correct_answer' => false,
    ],
    [
        'task_question_id' => $task_questions[5]->id,
        'the_answer' => '2',
        'correct_answer' => true,
    ],
    [
        'task_question_id' => $task_questions[5]->id,
        'the_answer' => '3',
        'correct_answer' => false,
    ],
    [
        'task_question_id' => $task_questions[6]->id,
        'the_answer' => 'a² + b² = c²',
        'correct_answer' => true,
    ],
    [
        'task_question_id' => $task_questions[6]->id,
        'the_answer' => 'a + b = c',
        'correct_answer' => false,
    ],
    [
        'task_question_id' => $task_questions[7]->id,
        'the_answer' => '120',
        'correct_answer' => true,
    ],
    [
        'task_question_id' => $task_questions[7]->id,
        'the_answer' => '24',
        'correct_answer' => false,
    ],
    [
        'task_question_id' => $task_questions[8]->id,
        'the_answer' => '15',
        'correct_answer' => true,
    ],
    [
        'task_question_id' => $task_questions[8]->id,
        'the_answer' => '20',
        'correct_answer' => false,
    ],
    [
        'task_question_id' => $task_questions[9]->id,
        'the_answer' => '15',
        'correct_answer' => true,
    ],
    [
        'task_question_id' => $task_questions[9]->id,
        'the_answer' => '20',
        'correct_answer' => false,
    ],
  /*  [
        'task_question_id' => $task_questions[10]->id,
        'the_answer' => '540°',
        'correct_answer' => true,
    ],
    [
        'task_question_id' => $task_questions[10]->id,
        'the_answer' => '360°',
        'correct_answer' => false,
    ],*/
];


foreach ($answers as $answer_data) {
    question_answer::create($answer_data);
}

$task = Task::create([
    'class_subject_id' => '16',
    'finished' =>'1',
    'total_grade'=>60
]);
$questions = [
    [
        'the_question' => 'what is x in x*x = 49 ?',
        'question_grade' => 5,
    ],
    [
        'the_question' => 'what is 2x+3=21?',
        'question_grade' => 5,
    ],
    [
        'the_question' => 'what is square root for 625?',
        'question_grade' => 10,
    ],
    [
        'the_question' => 'what is (x/2)*4=2 ?',
        'question_grade' => 10,
    ],
    [
        'the_question' => 'what is r in cycle ?',
        'question_grade' => 5,
    ],
    [
        'the_question' => 'when the triangle be standalone?',
        'question_grade' => 10,

    [
        'the_question' => 'what is the area for square?',
        'question_grade' => 5,
    ],
    ],
    [
        'the_question' => 'what is 2+2 ?',
        'question_grade' => 10,
    ],

];




$task_questions = [];
foreach ($questions as $question_data) {
    $task_questions[] = task_question::create([
        'task_id' => $task->id,
        'the_question' => $question_data['the_question'],
        'question_grade' => $question_data['question_grade'],
    ]);
}
$answers = [
    [
        'task_question_id' => $task_questions[0]->id,
        'the_answer' => '6',
        'correct_answer' => false,
    ],
    [
        'task_question_id' => $task_questions[0]->id,
        'the_answer' => '4',
        'correct_answer' => false,
    ],
    [
        'task_question_id' => $task_questions[0]->id,
        'the_answer' => '7   ',
        'correct_answer' => true,
    ],

    [
        'task_question_id' => $task_questions[1]->id,
        'the_answer' => '10',
        'correct_answer' => false,
    ],
    [
        'task_question_id' => $task_questions[1]->id,
        'the_answer' => '11',
        'correct_answer' => false,
    ],
    [
        'task_question_id' => $task_questions[1]->id,
        'the_answer' => ' 9 ',
        'correct_answer' => true,
    ],   [
        'task_question_id' => $task_questions[2]->id,
        'the_answer' => '25',
        'correct_answer' => true,
    ],
    [
        'task_question_id' => $task_questions[2]->id,
        'the_answer' => '35',
        'correct_answer' => false,
    ],
    [
        'task_question_id' => $task_questions[2]->id,
        'the_answer' => ' 12 ',
        'correct_answer' => false,
    ],   [
        'task_question_id' => $task_questions[3]->id,
        'the_answer' => '2',
        'correct_answer' => false,
    ],
    [
        'task_question_id' => $task_questions[3]->id,
        'the_answer' => '1.5',
        'correct_answer' => false,
    ],
    [
        'task_question_id' => $task_questions[3]->id,
        'the_answer' => ' 1',
        'correct_answer' => true,
    ],   [
        'task_question_id' => $task_questions[4]->id,
        'the_answer' => 'قطر الدائرة ',
        'correct_answer' => false,
    ],
    [
        'task_question_id' => $task_questions[4]->id,
        'the_answer' => 'محيط الدائرة',
        'correct_answer' => false,
    ],
    [
        'task_question_id' => $task_questions[4]->id,
        'the_answer' => ' نصف قطر الدائرة ',
        'correct_answer' => true,
    ],   [
        'task_question_id' => $task_questions[5]->id,
        'the_answer' => 'أحد زواياه أكبر من 90 درجة',
        'correct_answer' => false,
    ],
    [
        'task_question_id' => $task_questions[5]->id,
        'the_answer' => ' 90 أحد زواياه تساوي ',
        'correct_answer' => true,
    ],
    [
        'task_question_id' => $task_questions[5]->id,
        'the_answer' => 'ان يكون متساوي الساقين',
        'correct_answer' => false,
    ],   [
        'task_question_id' => $task_questions[6]->id,
        'the_answer' => '2/الطول* العرض',
        'correct_answer' => false,
    ],
    [
        'task_question_id' => $task_questions[6]->id,
        'the_answer' => 'الطول/2*العرض',
        'correct_answer' => false,
    ],
    [
        'task_question_id' => $task_questions[6]->id,
        'the_answer' => ' الطول*العرض ',
        'correct_answer' => true,
    ],  /* [
        'task_question_id' => $task_questions[7]->id,
        'the_answer' => '6',
        'correct_answer' => false,
    ],
    [
        'task_question_id' => $task_questions[7]->id,
        'the_answer' => '5',
        'correct_answer' => false,
    ],
    [
        'task_question_id' => $task_questions[7]->id,
        'the_answer' => '4 ',
        'correct_answer' => true,
    ],*/
   ];

foreach ($answers as $answer_data) {
    question_answer::create($answer_data);
}
$task = Task::create([
    'class_subject_id' => '16',
    'finished' =>'0',
    'total_grade'=>60
]);
$questions = [
    [
        'the_question' => 'what is the value of x in 2x + 5 = 11?',
        'question_grade' => 5,
    ],
    [
        'the_question' => 'what is the perimeter of a rectangle with length 6 and width 4?',
        'question_grade' => 10,
    ],
    [
        'the_question' => 'what is the equation of a line that passes through points (2,3) and (4,5)?',
        'question_grade' => 10,
    ],
    [
        'the_question' => 'what is the sum of the interior angles of a hexagon?',
        'question_grade' => 5,
    ],
    [
        'the_question' => 'what is the formula to find the area of a circle?',
        'question_grade' => 10,
    ],
    [
        'the_question' => 'what is the value of y in 3y - 2 = 14?',
        'question_grade' => 5,
    ],
    [
        'the_question' => 'what is the slope of a line that passes through points (1,2) and (3,4)?',
        'question_grade' => 10,
    ],
    [
        'the_question' => 'what is the equation of a circle with center (0,0) and radius 3?',
        'question_grade' => 10,
    ],
];
$task_questions = [];
foreach ($questions as $question_data) {
    $task_questions[] = task_question::create([
        'task_id' => $task->id,
        'the_question' => $question_data['the_question'],
        'question_grade' => $question_data['question_grade'],
    ]);
}

$answers = [
[
'task_question_id' => $task_questions[0]->id,
'the_answer' => '3',
'correct_answer' => true,
],
[
'task_question_id' => $task_questions[0]->id,
'the_answer' => '5',
'correct_answer' => false,
],
[
'task_question_id' => $task_questions[0]->id,
'the_answer' => '9',
'correct_answer' => false,
],

[
'task_question_id' => $task_questions[1]->id,
'the_answer' => '24',
'correct_answer' => true,
],
[
'task_question_id' => $task_questions[1]->id,
'the_answer' => '10',
'correct_answer' => false,
],
[
'task_question_id' => $task_questions[1]->id,
'the_answer' => '12',
'correct_answer' => false,
],

[
'task_question_id' => $task_questions[2]->id,
'the_answer' => 'y = x + 2',
'correct_answer' => true,
],
[
'task_question_id' => $task_questions[2]->id,
'the_answer' => 'y = 2x + 1',
'correct_answer' => false,
],
[
'task_question_id' => $task_questions[2]->id,
'the_answer' => 'y = x - 1',
'correct_answer' => false,
],

[
'task_question_id' => $task_questions[3]->id,
'the_answer' => '120',
'correct_answer' => true,
],
[
'task_question_id' => $task_questions[3]->id,
'the_answer' => '180',
'correct_answer' => false,
],
[
'task_question_id' => $task_questions[3]->id,
'the_answer' => '240',
'correct_answer' => false,
],

[
'task_question_id' => $task_questions[4]->id,
'the_answer' => 'πr^2',
'correct_answer' => true,
],
[
'task_question_id' => $task_questions[4]->id,
'the_answer' => '2πr',
'correct_answer' => false,
],
[
'task_question_id' => $task_questions[4]->id,
'the_answer' => 'πr',
'correct_answer' => false,
],

[
'task_question_id' => $task_questions[5]->id,
'the_answer' => '90 degrees',
'correct_answer' => true,
],
[
'task_question_id' => $task_questions[5]->id,
'the_answer' => '120 degrees',
'correct_answer' => false,
],
[
'task_question_id' => $task_questions[5]->id,
'the_answer' => '180 degrees',
'correct_answer' => false,
],

[
'task_question_id' => $task_questions[6]->id,
'the_answer' => 'y = 2x - 3',
'correct_answer' => true,
],
[
'task_question_id' => $task_questions[6]->id,
'the_answer' => 'y = x + 2',
'correct_answer' => false,
],
[
'task_question_id' => $task_questions[6]->id,
'the_answer' => 'y = 3x - 2',
'correct_answer' => false,
],

[
'task_question_id' => $task_questions[7]->id,
'the_answer' => '(x-3)^2 + (y-4)^2 = 9',
'correct_answer' => true,
],
[
'task_question_id' => $task_questions[7]->id,
'the_answer' => '(x-2)^2 + (y-3)^2 = 4',
'correct_answer' => false,
],
[
'task_question_id' => $task_questions[7]->id,
'the_answer' => '(x-4)^2 + (y-2)^2 = 16',
'correct_answer' => false,
],
];
foreach ($answers as $answer_data) {
question_answer::create($answer_data);
}


    }

}
