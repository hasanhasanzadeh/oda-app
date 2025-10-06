<?php

namespace App\Models;

use App\Base\Trait\HasRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mark extends Model
{
    use HasFactory, HasRules;

    /*
     * ---------------------------
     *          Constants
     * ---------------------------
     */
    const ID = 'id';
    const NAME = 'name';
    const TITLE = 'title';
    const DESCRIPTION = 'description';
    const SCORE = 'score';
    const MAX_SCORE = 'max_score';
    const MIN_SCORE = 'min_score';
    const GRADE = 'grade';
    const PERCENTAGE = 'percentage';
    const DEPARTMENT_ID = 'department_id';
    const STUDENT_ID = 'student_id';
    const EXAM_ID = 'exam_id';
    const COURSE_ID = 'course_id';
    const TEACHER_ID = 'teacher_id';
    const IS_PASSED = 'is_passed';
    const MARKED_AT = 'marked_at';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'deleted_at';

    protected $table = 'marks';

    protected $fillable = [
        self::NAME,
        self::TITLE,
        self::DESCRIPTION,
        self::SCORE,
        self::MAX_SCORE,
        self::MIN_SCORE,
        self::GRADE,
        self::PERCENTAGE,
        self::DEPARTMENT_ID,
        self::STUDENT_ID,
        self::EXAM_ID,
        self::COURSE_ID,
        self::TEACHER_ID,
        self::IS_PASSED,
        self::MARKED_AT,
    ];

    protected $casts = [
        self::ID => 'int',
        self::SCORE => 'decimal:2',
        self::MAX_SCORE => 'decimal:2',
        self::MIN_SCORE => 'decimal:2',
        self::PERCENTAGE => 'decimal:2',
        self::IS_PASSED => 'boolean',
        self::MARKED_AT => 'datetime',
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime',
    ];

    protected static array $rules = [
        'name' => 'nullable|string|min:2|max:255',
        'title' => 'required|string|min:3|max:255',
        'description' => 'nullable|string|max:1000',
        'score' => 'required|numeric|min:0',
        'max_score' => 'required|numeric|min:1',
        'min_score' => 'nullable|numeric|min:0|lte:max_score',
        'grade' => 'nullable|string|max:10',
        'percentage' => 'nullable|numeric|min:0|max:100',
        'department_id' => 'nullable|exists:departments,id',
        'student_id' => 'required|exists:users,id',
        'exam_id' => 'nullable|exists:exams,id',
        'course_id' => 'required|exists:courses,id',
        'teacher_id' => 'required|exists:users,id',
        'is_passed' => 'boolean',
        'marked_at' => 'nullable|date',
    ];

    /*
     * ---------------------------
     *          Relations
     * ---------------------------
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, self::STUDENT_ID);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, self::TEACHER_ID);
    }

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_mark', 'mark_id', 'course_id')
            ->withPivot('id', 'course_id', 'mark_id', 'capacity')
            ->using(CourseMark::class)
            ->withTimestamps();
    }

    /*
     * ---------------------------
     *          Scopes
     * ---------------------------
     */
    public function scopePassed($query)
    {
        return $query->where(self::IS_PASSED, true);
    }

    public function scopeFailed($query)
    {
        return $query->where(self::IS_PASSED, false);
    }

    public function scopeByDepartment($query, $departmentId)
    {
        return $query->where(self::DEPARTMENT_ID, $departmentId);
    }

    public function scopeByStudent($query, $studentId)
    {
        return $query->where(self::STUDENT_ID, $studentId);
    }

    public function scopeByCourse($query, $courseId)
    {
        return $query->where(self::COURSE_ID, $courseId);
    }

    public function scopeByExam($query, $examId)
    {
        return $query->where(self::EXAM_ID, $examId);
    }

    public function scopeByTeacher($query, $teacherId)
    {
        return $query->where(self::TEACHER_ID, $teacherId);
    }

    public function scopeAboveScore($query, $minScore)
    {
        return $query->where(self::SCORE, '>=', $minScore);
    }

    public function scopeBelowScore($query, $maxScore)
    {
        return $query->where(self::SCORE, '<=', $maxScore);
    }

    public function scopeRecentlyMarked($query, $days = 7)
    {
        return $query->where(self::MARKED_AT, '>=', now()->subDays($days));
    }

    /*
     * ---------------------------
     *          Accessors
     * ---------------------------
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->name ?: $this->title;
    }

    public function getFormattedScoreAttribute(): string
    {
        return $this->score . '/' . $this->max_score;
    }

    public function getCalculatedPercentageAttribute(): float
    {
        if ($this->max_score > 0) {
            return round(($this->score / $this->max_score) * 100, 2);
        }

        return 0;
    }

    public function getGradeLetterAttribute(): string
    {
        $percentage = $this->calculated_percentage;

        if ($percentage >= 90) return 'A';
        if ($percentage >= 80) return 'B';
        if ($percentage >= 70) return 'C';
        if ($percentage >= 60) return 'D';
        return 'F';
    }

    public function getStatusAttribute(): string
    {
        return $this->is_passed ? 'Passed' : 'Failed';
    }

    /*
     * ---------------------------
     *          Mutators
     * ---------------------------
     */
    public function setScoreAttribute($value)
    {
        $this->attributes[self::SCORE] = $value;

        // Auto-calculate percentage and pass/fail status
        if ($this->max_score > 0) {
            $this->attributes[self::PERCENTAGE] = round(($value / $this->max_score) * 100, 2);
            $this->attributes[self::IS_PASSED] = $value >= ($this->min_score ?: ($this->max_score * 0.6));
        }
    }

    /*
     * ---------------------------
     *          Methods
     * ---------------------------
     */
    public function calculateGrade(): string
    {
        return $this->grade_letter;
    }

    public function isPassingGrade(): bool
    {
        $minScore = $this->min_score ?: ($this->max_score * 0.6);
        return $this->score >= $minScore;
    }
}
